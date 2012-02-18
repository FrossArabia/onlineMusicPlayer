ID3v2 = {
	parseStream: function(stream, onComplete){

	var PICTURE_TYPES = {
		"0": "Other",
		"1": "32x32 pixels 'file icon' (PNG only)",
		"2": "Other file icon",
		"3": "Cover (front)",
		"4": "Cover (back)",
		"5": "Leaflet page",
		"6": "Media (e.g. lable side of CD)",
		"7": "Lead artist/lead performer/soloist",
		"8": "Artist/performer",
		"9": "Conductor",
		"A": "Band/Orchestra",
		"B": "Composer",
		"C": "Lyricist/text writer",
		"D": "Recording Location",
		"E": "During recording",
		"F": "During performance",
		"10": "Movie/video screen capture",
		"11": "A bright coloured fish", //<--- WTF?
		"12": "Illustration",
		"13": "Band/artist logotype",
		"14": "Publisher/Studio logotype"
	};
	
	var TAGS = {
		"AENC": "Audio encryption",
		"APIC": "Attached picture"
	};

	var TAG_MAPPING_2_2_to_2_3 = {
	};
		
	var tag = {
		pictures: []
	};
	
	
	var max_size = Infinity;
	
	function read(bytes, callback){
		stream(bytes, callback, max_size);
	}
	
	
	function encode_64(input) {
		var output = "", i = 0, l = input.length,
		key = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=", 
		chr1, chr2, chr3, enc1, enc2, enc3, enc4;
		while (i < l) {
			chr1 = input.charCodeAt(i++);
			chr2 = input.charCodeAt(i++);
			chr3 = input.charCodeAt(i++);
			enc1 = chr1 >> 2;
			enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
			enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
			enc4 = chr3 & 63;
			if (isNaN(chr2)) enc3 = enc4 = 64;
			else if (isNaN(chr3)) enc4 = 64;
			output = output + key.charAt(enc1) + key.charAt(enc2) + key.charAt(enc3) + key.charAt(enc4);
		}
		return output;
	}
	
	function pad(num){
		var arr = num.toString(2);
		return (new Array(8-arr.length+1)).join('0') + arr;
	}

	function arr2int(data){
		if(data.length == 4){
			if(tag.revision > 3){
				var size = data[0] << 0x15;
				size += data[1] << 14;
				size += data[2] << 7;
				size += data[3];
			}else{
				var size = data[0] << 24;
				size += data[1] << 16;
				size += data[2] << 8;
				size += data[3];
			}
		}else{
			var size = data[0] << 16;
			size += data[1] << 8;
			size += data[2];
		}
		return size;
	}
	
	function parseImage(str){
		var TextEncoding = str.charCodeAt(0);
		str = str.substr(1);
		var MimeTypePos = str.indexOf('\0');
		var MimeType = str.substr(0, MimeTypePos);
		str = str.substr(MimeTypePos+1);
		var PictureType = str.charCodeAt(0);
		var TextPictureType = PICTURE_TYPES[PictureType.toString(16).toUpperCase()];
		str = str.substr(1);
		var DescriptionPos = str.indexOf('\0');
		var Description = str.substr(0, DescriptionPos);
		str = str.substr(DescriptionPos+1);
		var PictureData = str;
		var Magic = PictureData.split('').map(function(e){return String.fromCharCode(e.charCodeAt(0) & 0xff)}).join('');
		return {
			dataURL: 'data:'+MimeType+';base64,'+encode_64(Magic),
			PictureType: TextPictureType,
			Description: Description,
			MimeType: MimeType
		};
	}
	
	function parseImage2(str){
		var TextEncoding = str.charCodeAt(0);
		str = str.substr(1);
		var Type = str.substr(0, 3);
		str = str.substr(3);
		
		var PictureType = str.charCodeAt(0);
		var TextPictureType = PICTURE_TYPES[PictureType.toString(16).toUpperCase()];
		
		str = str.substr(1);
		var DescriptionPos = str.indexOf('\0');
		var Description = str.substr(0, DescriptionPos);
		str = str.substr(DescriptionPos+1);
		var PictureData = str;
		var Magic = PictureData.split('').map(function(e){return String.fromCharCode(e.charCodeAt(0) & 0xff)}).join('');
		return {
			dataURL: 'data:img/'+Type+';base64,'+encode_64(Magic),
			PictureType: TextPictureType,
			Description: Description,
			MimeType: MimeType
		};
	}

	var TAG_HANDLERS = {
		"APIC": function(size, s, a){
			tag.pictures.push(parseImage(s));
		},
		"PIC": function(size, s, a){
			tag.pictures.push(parseImage2(s));
		}
	};

	function read_frame(){
		if(tag.revision < 3){
			read(3, function(frame_id){
				//console.log(frame_id)
				if(/[A-Z0-9]{3}/.test(frame_id)){
					var new_frame_id = TAG_MAPPING_2_2_to_2_3[frame_id.substr(0,3)];
					read_frame2(frame_id, new_frame_id);
				}else{
					onComplete(tag);
					return;
				}
			})
		}else{
			read(4, function(frame_id){
				//console.log(frame_id)
				if(/[A-Z0-9]{4}/.test(frame_id)){
					read_frame3(frame_id);
				}else{
					onComplete(tag);
					return;
				}
			})
		}
	}
	
	
	function cleanText(str){
		if(str.indexOf('http://') != 0){
			var TextEncoding = str.charCodeAt(0);
			str = str.substr(1);
		}

		//screw it i have no clue
		return str.replace(/[^A-Za-z0-9\(\)\{\}\[\]\!\@\#\$\%\^\&\* \/\"\'\;\>\<\?\,\~\`\.\n\t]/g,'');
	}
	
	
	function read_frame3(frame_id){
		read(4, function(s, size){
			var intsize = arr2int(size);
			read(2, function(s, flags){
				flags = pad(flags[0]).concat(pad(flags[1]));
				read(intsize, function(s, a){
					if(typeof TAG_HANDLERS[frame_id] == 'function'){
						TAG_HANDLERS[frame_id](intsize, s, a);
					}else if(TAGS[frame_id]){
						tag[TAGS[frame_id]] = (tag[TAGS[frame_id]]||'') + cleanText(s)
					}else{
						tag[frame_id] = cleanText(s)
					}
					read_frame();
				})
			})
		})
	}
	
	function read_frame2(v2ID, frame_id){
		read(3, function(s, size){
			var intsize = arr2int(size);
			read(intsize, function(s, a){
				if(typeof TAG_HANDLERS[v2ID] == 'function'){
					TAG_HANDLERS[v2ID](intsize, s, a);
				}else if(typeof TAG_HANDLERS[frame_id] == 'function'){
					TAG_HANDLERS[frame_id](intsize, s, a);
				}else if(TAGS[frame_id]){
					tag[TAGS[frame_id]] = (tag[TAGS[frame_id]]||'') + cleanText(s)
				}else{
						tag[frame_id] = cleanText(s)
					}
									//console.log(tag)
				read_frame();
			})
		})
	}
	
	
	read(3, function(header){
		if(header == "ID3"){
			read(2, function(s, version){
				tag.version = "ID3v2."+version[0]+'.'+version[1];
				tag.revision = version[0];
				//console.log('version',tag.version);
				read(1, function(s, flags){
					//todo: parse flags
					flags = pad(flags[0]);
					read(4, function(s, size){
						max_size = arr2int(size);
						read(0, function(){}); //signal max
						read_frame()
					})
				})
			})
		}else{
			onComplete(tag);
			return false; //no header found
		}
	})
	return tag;
},
parseFile: function(file, onComplete){
	var reader = new FileReader();
	var pos = 0, 
			bits_required = 0, 
			handle = function(){},
			maxdata = Infinity;

	function read(bytes, callback, newmax){
		bits_required = bytes;
		handle = callback;
		maxdata = newmax;
		if(bytes == 0) callback('',[]);
	}
	var responseText = '';
	reader.onload = function(){
		responseText = reader.result;
	};

	(function(){
		if(responseText.length > pos + bits_required && bits_required){
			var data = responseText.substr(pos, bits_required);
			var arrdata = data.split('').map(function(e){return e.charCodeAt(0) & 0xff});
			pos += bits_required;
			bits_required = 0;
			if(handle(data, arrdata) === false){
				return;
			}
		}
		setTimeout(arguments.callee, 0);
	})()
	reader.readAsBinaryString(fileSlice(file, 0, 256 * 1024));
	return [reader, ID3v2.parseStream(read, onComplete)];
 }
}

function fileSlice(file, start, length){
  if(file.mozSlice) return file.mozSlice(start, start + length);
  if(file.webkitSlice) return file.webkitSlice(start, start + length);
  if(file.slice) return file.slice(start, length);
}