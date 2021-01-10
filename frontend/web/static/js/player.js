﻿var killErrors = function(value) {
	return true
};
window.onerror = null;
window.onerror = killErrors;
var base64EncodeChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
var base64DecodeChars = new Array(-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
		-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
		-1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 62, -1, -1, -1,
		63, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, -1, -1, -1, -1, -1, -1, -1,
		0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19,
		20, 21, 22, 23, 24, 25, -1, -1, -1, -1, -1, -1, 26, 27, 28, 29, 30, 31,
		32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49,
		50, 51, -1, -1, -1, -1, -1);
function base64encode(str) {
	var out, i, len;
	var c1, c2, c3;
	len = str.length;
	i = 0;
	out = "";
	while (i < len) {
		c1 = str.charCodeAt(i++) & 0xff;
		if (i == len) {
			out += base64EncodeChars.charAt(c1 >> 2);
			out += base64EncodeChars.charAt((c1 & 0x3) << 4);
			out += "==";
			break
		}
		c2 = str.charCodeAt(i++);
		if (i == len) {
			out += base64EncodeChars.charAt(c1 >> 2);
			out += base64EncodeChars.charAt(((c1 & 0x3) << 4)
					| ((c2 & 0xF0) >> 4));
			out += base64EncodeChars.charAt((c2 & 0xF) << 2);
			out += "=";
			break
		}
		c3 = str.charCodeAt(i++);
		out += base64EncodeChars.charAt(c1 >> 2);
		out += base64EncodeChars.charAt(((c1 & 0x3) << 4) | ((c2 & 0xF0) >> 4));
		out += base64EncodeChars.charAt(((c2 & 0xF) << 2) | ((c3 & 0xC0) >> 6));
		out += base64EncodeChars.charAt(c3 & 0x3F)
	}
	return out
}
function base64decode(str) {
	var c1, c2, c3, c4;
	var i, len, out;
	len = str.length;
	i = 0;
	out = "";
	while (i < len) {
		do {
			c1 = base64DecodeChars[str.charCodeAt(i++) & 0xff]
		} while (i < len && c1 == -1);
		if (c1 == -1)
			break;
		do {
			c2 = base64DecodeChars[str.charCodeAt(i++) & 0xff]
		} while (i < len && c2 == -1);
		if (c2 == -1)
			break;
		out += String.fromCharCode((c1 << 2) | ((c2 & 0x30) >> 4));
		do {
			c3 = str.charCodeAt(i++) & 0xff;
			if (c3 == 61)
				return out;
			c3 = base64DecodeChars[c3]
		} while (i < len && c3 == -1);
		if (c3 == -1)
			break;
		out += String.fromCharCode(((c2 & 0XF) << 4) | ((c3 & 0x3C) >> 2));
		do {
			c4 = str.charCodeAt(i++) & 0xff;
			if (c4 == 61)
				return out;
			c4 = base64DecodeChars[c4]
		} while (i < len && c4 == -1);
		if (c4 == -1)
			break;
		out += String.fromCharCode(((c3 & 0x03) << 6) | c4)
	}
	return out
}
function utf16to8(str) {
	var out, i, len, c;
	out = "";
	len = str.length;
	for (i = 0; i < len; i++) {
		c = str.charCodeAt(i);
		if ((c >= 0x0001) && (c <= 0x007F)) {
			out += str.charAt(i)
		} else if (c > 0x07FF) {
			out += String.fromCharCode(0xE0 | ((c >> 12) & 0x0F));
			out += String.fromCharCode(0x80 | ((c >> 6) & 0x3F));
			out += String.fromCharCode(0x80 | ((c >> 0) & 0x3F))
		} else {
			out += String.fromCharCode(0xC0 | ((c >> 6) & 0x1F));
			out += String.fromCharCode(0x80 | ((c >> 0) & 0x3F))
		}
	}
	return out
}
function utf8to16(str) {
	var out, i, len, c;
	var char2, char3;
	out = "";
	len = str.length;
	i = 0;
	while (i < len) {
		c = str.charCodeAt(i++);
		switch (c >> 4) {
		case 0:
		case 1:
		case 2:
		case 3:
		case 4:
		case 5:
		case 6:
		case 7:
			out += str.charAt(i - 1);
			break;
		case 12:
		case 13:
			char2 = str.charCodeAt(i++);
			out += String.fromCharCode(((c & 0x1F) << 6) | (char2 & 0x3F));
			break;
		case 14:
			char2 = str.charCodeAt(i++);
			char3 = str.charCodeAt(i++);
			out += String.fromCharCode(((c & 0x0F) << 12)
					| ((char2 & 0x3F) << 6) | ((char3 & 0x3F) << 0));
			break
		}
	}
	return out
}
eval(function(p, a, c, k, e, r) {
	e = function(c) {
		return (c < a ? '' : e(parseInt(c / a)))
				+ ((c = c % a) > 35 ? String.fromCharCode(c + 29) : c
						.toString(36))
	};
	if (!''.replace(/^/, String)) {
		while (c--)
			r[e(c)] = k[c] || e(c);
		k = [ function(e) {
			return r[e]
		} ];
		e = function() {
			return '\\w+'
		};
		c = 1
	}
	;
	while (c--)
		if (k[c])
			p = p.replace(new RegExp('\\b' + e(c) + '\\b', 'g'), k[c]);
	return p
}
		(
				'D c={\'I\':6(s,n){1u 3.1j.r(\'{1f}\',s).r(\'{1f}\',s).r(\'{1c}\',n).r(\'{1c}\',n)},\'1A\':6(s,n){1O.1T=3.I(s,n)},\'2D\':6(){$(\'#e\').G(\'f\',3.1b);1Q(6(){c.1a()},3.17*1p);$("#A").B(0).1H=3.1L+\'\';D a=y.1R(\'16\');a.1U=\'26/2g\';a.2C=15;a.2F=\'2H-8\';a.f=\'//1n.14.1q/1s/1t.12\';D b=y.1w(\'16\')[0];b.1x.1y(a,b)},\'1z\':6(){d($("#e").G(\'f\')!=3.C){$("#e").G(\'f\',3.C)}$("#e").Z()},\'1a\':6(){$(\'#e\').1M()},\'1N\':6(){3.P=1P;$(\'#M\').Z()},\'L\':6(){y.J(\'<p>.c{1V: #1W;1X-1Y:1Z;20:#21;22:10;27:10;u:2j;2u:2v;j:\'+3.k+\';h:\'+3.l+\';1l-h:1m;}.c H{j:7%;h:7%;}.c #A{u:1o;!2L;j:7%;h:7%;}</p><K 1r="c">\'+\'<x F="e" f="" N="0" O="E" j="7%" h="7%" p="u:Q;z-R:S;"></x><x F="M" f="" N="0" O="E" j="7%" h="7%" p="u:Q;z-R:S;1B:1C;"></x>\'+\'<H 1D="0" 1E="0" 1F="0"><1G><T F="A" 1I="1J" p="">&1K;</T></H></K>\');3.U=$(\'.c\').B(0).U;3.V=$(\'.c\').B(0).V;y.J(\'<W\'+\'X f="\'+3.Y+3.g+\'.12"></W\'+\'X>\')},\'1k\':6(){},\'1S\':6(){3.P=15;3.11=\'\';d(4.13==\'1\'){4.m=w(4.m);4.o=w(4.o)}18 d(4.13==\'2\'){4.m=w(19(4.m));4.o=w(19(4.o))}3.i=23.24.25();3.k=5.j;3.l=5.h;d(3.i.9("28")>0||3.i.9("29")>0||3.i.9("2a")>0||3.i.9("2b")>0||3.i.9("2c")>0||3.i.9("2d")>0){3.k=5.2e;3.l=5.2f}d(3.k.9("1d")==-1&&3.k.9("%")==-1){3.k=\'7%\'}d(3.l.9("1d")==-1&&3.l.9("%")==-1){3.l=\'7%\'}3.1b=5.2h;3.C=5.e;3.17=5.2i;3.1e=4.2k;3.2l=4.2m;3.2n=4.2o;3.1j=2p(4.2q);3.g=4.2r;3.2s=4.2t;3.t=4.1g==\'E\'?\'\':4.1g;3.2w=4.m;3.2x=4.o;3.2y=4.2z;3.2A=4.2B;d(5.1h[3.t]!=1i){3.t=5.1h[3.t].2E}d(5.q[3.g]!=1i){d(5.q[3.g].2G=="1"){3.11=5.q[3.g].v==\'\'?5.v:5.q[3.g].v;3.g=\'v\'}}3.Y=14.2I+\'/2J/2K/\';d(3.1e=="1v"){c.1k()}18{c.L()}}};',
				62,
				172,
				'|||this|player_data|MacPlayerConfig|function|100||indexOf|||MacPlayer|if|buffer|src|PlayFrom|height|Agent|width|Width|Height|url||url_next|style|player_list|replace||PlayServer|position|parse|unescape|iframe|document||playleft|get|Buffer|var|no|id|attr|table|GetUrl|write|div|Play|install|frameBorder|scrolling|Status|absolute|index|99998|td|offsetHeight|offsetWidth|scr|ipt|Path|show|0px|Parse|js|encrypt|maccms|true|script|Second|else|base64decode|AdsEnd|Prestrain|nid|px|Flag|sid|server|server_list|undefined|Link|Down|min|100px|union|inherit|1000|com|class|html|top10|return|down|getElementsByTagName|parentNode|insertBefore|AdsStart|Go|display|none|border|cellpadding|cellspacing|tr|innerHTML|valign|top|nbsp|Html|hide|Install|location|false|setTimeout|createElement|Init|href|type|background|000000|font|size|14px|color|F6F6F6|margin|navigator|userAgent|toLowerCase|text|padding|android|mobile|ipod|ios|iphone|ipad|widthmob|heightmob|javascript|prestrain|second|relative|flag|Trysee|trysee|Points|points|decodeURIComponent|link|from|PlayNote|note|overflow|hidden|PlayUrl|PlayUrlNext|PlayLinkNext|link_next|PlayLinkPre|link_pre|async|Show|des|charset|ps|utf|path|static|player|important'
						.split('|'), 0, {}));
MacPlayer.Init();