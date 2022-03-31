<script>(function(){/*

 Copyright The Closure Library Authors.
 SPDX-License-Identifier: Apache-2.0
*/
'use strict';var g=function(a){var b=0;return function(){return b<a.length?{done:!1,value:a[b++]}:{done:!0}}},l=this||self,m=/^[\w+/_-]+[=]{0,2}$/,p=null,q=function(){},r=function(a){var b=typeof a;if("object"==b)if(a){if(a instanceof Array)return"array";if(a instanceof Object)return b;var c=Object.prototype.toString.call(a);if("[object Window]"==c)return"object";if("[object Array]"==c||"number"==typeof a.length&&"undefined"!=typeof a.splice&&"undefined"!=typeof a.propertyIsEnumerable&&!a.propertyIsEnumerable("splice"))return"array";
if("[object Function]"==c||"undefined"!=typeof a.call&&"undefined"!=typeof a.propertyIsEnumerable&&!a.propertyIsEnumerable("call"))return"function"}else return"null";else if("function"==b&&"undefined"==typeof a.call)return"object";return b},u=function(a,b){function c(){}c.prototype=b.prototype;a.prototype=new c;a.prototype.constructor=a};var v=function(a,b){Object.defineProperty(l,a,{configurable:!1,get:function(){return b},set:q})};var y=function(a,b){this.b=a===w&&b||"";this.a=x},x={},w={};var aa=function(a,b){a.src=b instanceof y&&b.constructor===y&&b.a===x?b.b:"type_error:TrustedResourceUrl";if(null===p)b:{b=l.document;if((b=b.querySelector&&b.querySelector("script[nonce]"))&&(b=b.nonce||b.getAttribute("nonce"))&&m.test(b)){p=b;break b}p=""}b=p;b&&a.setAttribute("nonce",b)};var z=function(){return Math.floor(2147483648*Math.random()).toString(36)+Math.abs(Math.floor(2147483648*Math.random())^+new Date).toString(36)};var A=function(a,b){b=String(b);"application/xhtml+xml"===a.contentType&&(b=b.toLowerCase());return a.createElement(b)},B=function(a){this.a=a||l.document||document};B.prototype.appendChild=function(a,b){a.appendChild(b)};var C=function(a,b,c,d,e,f){try{var k=a.a,h=A(a.a,"SCRIPT");h.async=!0;aa(h,b);k.head.appendChild(h);h.addEventListener("load",function(){e();d&&k.head.removeChild(h)});h.addEventListener("error",function(){0<c?C(a,b,c-1,d,e,f):(d&&k.head.removeChild(h),f())})}catch(n){f()}};var ba=l.atob("aHR0cHM6Ly93d3cuZ3N0YXRpYy5jb20vaW1hZ2VzL2ljb25zL21hdGVyaWFsL3N5c3RlbS8xeC93YXJuaW5nX2FtYmVyXzI0ZHAucG5n"),ca=l.atob("WW91IGFyZSBzZWVpbmcgdGhpcyBtZXNzYWdlIGJlY2F1c2UgYWQgb3Igc2NyaXB0IGJsb2NraW5nIHNvZnR3YXJlIGlzIGludGVyZmVyaW5nIHdpdGggdGhpcyBwYWdlLg=="),da=l.atob("RGlzYWJsZSBhbnkgYWQgb3Igc2NyaXB0IGJsb2NraW5nIHNvZnR3YXJlLCB0aGVuIHJlbG9hZCB0aGlzIHBhZ2Uu"),ea=function(a,b,c){this.b=a;this.f=new B(this.b);this.a=null;this.c=[];this.g=!1;this.i=b;this.h=c},F=function(a){if(a.b.body&&!a.g){var b=
function(){D(a);l.setTimeout(function(){return E(a,3)},50)};C(a.f,a.i,2,!0,function(){l[a.h]||b()},b);a.g=!0}},D=function(a){for(var b=G(1,5),c=0;c<b;c++){var d=H(a);a.b.body.appendChild(d);a.c.push(d)}b=H(a);b.style.bottom="0";b.style.left="0";b.style.position="fixed";b.style.width=G(100,110).toString()+"%";b.style.zIndex=G(2147483544,2147483644).toString();b.style["background-color"]=I(249,259,242,252,219,229);b.style["box-shadow"]="0 0 12px #888";b.style.color=I(0,10,0,10,0,10);b.style.display=
"flex";b.style["justify-content"]="center";b.style["font-family"]="Roboto, Arial";c=H(a);c.style.width=G(80,85).toString()+"%";c.style.maxWidth=G(750,775).toString()+"px";c.style.margin="24px";c.style.display="flex";c.style["align-items"]="flex-start";c.style["justify-content"]="center";d=A(a.f.a,"IMG");d.className=z();d.src=ba;d.style.height="24px";d.style.width="24px";d.style["padding-right"]="16px";var e=H(a),f=H(a);f.style["font-weight"]="bold";f.textContent=ca;var k=H(a);k.textContent=da;J(a,
e,f);J(a,e,k);J(a,c,d);J(a,c,e);J(a,b,c);a.a=b;a.b.body.appendChild(a.a);b=G(1,5);for(c=0;c<b;c++)d=H(a),a.b.body.appendChild(d),a.c.push(d)},J=function(a,b,c){for(var d=G(1,5),e=0;e<d;e++){var f=H(a);b.appendChild(f)}b.appendChild(c);c=G(1,5);for(d=0;d<c;d++)e=H(a),b.appendChild(e)},G=function(a,b){return Math.floor(a+Math.random()*(b-a))},I=function(a,b,c,d,e,f){return"rgb("+G(Math.max(a,0),Math.min(b,255)).toString()+","+G(Math.max(c,0),Math.min(d,255)).toString()+","+G(Math.max(e,0),Math.min(f,
255)).toString()+")"},H=function(a){a=A(a.f.a,"DIV");a.className=z();return a},E=function(a,b){0>=b||null!=a.a&&0!=a.a.offsetHeight&&0!=a.a.offsetWidth||(fa(a),D(a),l.setTimeout(function(){return E(a,b-1)},50))},fa=function(a){var b=a.c;var c="undefined"!=typeof Symbol&&Symbol.iterator&&b[Symbol.iterator];b=c?c.call(b):{next:g(b)};for(c=b.next();!c.done;c=b.next())(c=c.value)&&c.parentNode&&c.parentNode.removeChild(c);a.c=[];(b=a.a)&&b.parentNode&&b.parentNode.removeChild(b);a.a=null};var ia=function(a,b,c,d,e){var f=ha(c),k=function(n){n.appendChild(f);l.setTimeout(function(){f?(0!==f.offsetHeight&&0!==f.offsetWidth?b():a(),f.parentNode&&f.parentNode.removeChild(f)):a()},d)},h=function(n){document.body?k(document.body):0<n?l.setTimeout(function(){h(n-1)},e):b()};h(3)},ha=function(a){var b=document.createElement("div");b.className=a;b.style.width="1px";b.style.height="1px";b.style.position="absolute";b.style.left="-10000px";b.style.top="-10000px";b.style.zIndex="-10000";return b};var K={},L=null;var M=function(){},N="function"==typeof Uint8Array,O=function(a,b){a.b=null;b||(b=[]);a.j=void 0;a.f=-1;a.a=b;a:{if(b=a.a.length){--b;var c=a.a[b];if(!(null===c||"object"!=typeof c||Array.isArray(c)||N&&c instanceof Uint8Array)){a.g=b-a.f;a.c=c;break a}}a.g=Number.MAX_VALUE}a.i={}},P=[],Q=function(a,b){if(b<a.g){b+=a.f;var c=a.a[b];return c===P?a.a[b]=[]:c}if(a.c)return c=a.c[b],c===P?a.c[b]=[]:c},R=function(a,b,c){a.b||(a.b={});if(!a.b[c]){var d=Q(a,c);d&&(a.b[c]=new b(d))}return a.b[c]};
M.prototype.h=N?function(){var a=Uint8Array.prototype.toJSON;Uint8Array.prototype.toJSON=function(){var b;void 0===b&&(b=0);if(!L){L={};for(var c="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789".split(""),d=["+/=","+/","-_=","-_.","-_"],e=0;5>e;e++){var f=c.concat(d[e].split(""));K[e]=f;for(var k=0;k<f.length;k++){var h=f[k];void 0===L[h]&&(L[h]=k)}}}b=K[b];c=[];for(d=0;d<this.length;d+=3){var n=this[d],t=(e=d+1<this.length)?this[d+1]:0;h=(f=d+2<this.length)?this[d+2]:0;k=n>>2;n=(n&
3)<<4|t>>4;t=(t&15)<<2|h>>6;h&=63;f||(h=64,e||(t=64));c.push(b[k],b[n],b[t]||"",b[h]||"")}return c.join("")};try{return JSON.stringify(this.a&&this.a,S)}finally{Uint8Array.prototype.toJSON=a}}:function(){return JSON.stringify(this.a&&this.a,S)};var S=function(a,b){return"number"!==typeof b||!isNaN(b)&&Infinity!==b&&-Infinity!==b?b:String(b)};M.prototype.toString=function(){return this.a.toString()};var T=function(a){O(this,a)};u(T,M);var U=function(a){O(this,a)};u(U,M);var ja=function(a,b){this.c=new B(a);var c=R(b,T,5);c=new y(w,Q(c,4)||"");this.b=new ea(a,c,Q(b,4));this.a=b},ka=function(a,b,c,d){b=new T(b?JSON.parse(b):null);b=new y(w,Q(b,4)||"");C(a.c,b,3,!1,c,function(){ia(function(){F(a.b);d(!1)},function(){d(!0)},Q(a.a,2),Q(a.a,3),Q(a.a,1))})};var la=function(a,b){V(a,"internal_api_load_with_sb",function(c,d,e){ka(b,c,d,e)});V(a,"internal_api_sb",function(){F(b.b)})},V=function(a,b,c){a=l.btoa(a+b);v(a,c)},W=function(a,b,c){for(var d=[],e=2;e<arguments.length;++e)d[e-2]=arguments[e];e=l.btoa(a+b);e=l[e];if("function"==r(e))e.apply(null,d);else throw Error("API not exported.");};var X=function(a){O(this,a)};u(X,M);var Y=function(a){this.h=window;this.a=a;this.b=Q(this.a,1);this.f=R(this.a,T,2);this.g=R(this.a,U,3);this.c=!1};Y.prototype.start=function(){ma();var a=new ja(this.h.document,this.g);la(this.b,a);na(this)};
var ma=function(){var a=function(){if(!l.frames.googlefcPresent)if(document.body){var b=document.createElement("iframe");b.style.display="none";b.style.width="0px";b.style.height="0px";b.style.border="none";b.style.zIndex="-1000";b.style.left="-1000px";b.style.top="-1000px";b.name="googlefcPresent";document.body.appendChild(b)}else l.setTimeout(a,5)};a()},na=function(a){var b=Date.now();W(a.b,"internal_api_load_with_sb",a.f.h(),function(){var c;var d=a.b,e=l[l.btoa(d+"loader_js")];if(e){e=l.atob(e);
e=parseInt(e,10);d=l.btoa(d+"loader_js").split(".");var f=l;d[0]in f||"undefined"==typeof f.execScript||f.execScript("var "+d[0]);for(;d.length&&(c=d.shift());)d.length?f[c]&&f[c]!==Object.prototype[c]?f=f[c]:f=f[c]={}:f[c]=null;c=Math.abs(b-e);c=1728E5>c?0:c}else c=-1;0!=c&&(W(a.b,"internal_api_sb"),Z(a,Q(a.a,6)))},function(c){Z(a,c?Q(a.a,4):Q(a.a,5))})},Z=function(a,b){a.c||(a.c=!0,a=new l.XMLHttpRequest,a.open("GET",b,!0),a.send())};(function(a,b){l[a]=function(c){for(var d=[],e=0;e<arguments.length;++e)d[e-0]=arguments[e];l[a]=q;b.apply(null,d)}})("__d3lUW8vwsKlB__",function(a){"function"==typeof window.atob&&(a=window.atob(a),a=new X(a?JSON.parse(a):null),(new Y(a)).start())});}).call(this);

window.__d3lUW8vwsKlB__("WyI5NzA0YWUxZWJiYWQ5ZGIiLFtudWxsLG51bGwsbnVsbCwiaHR0cHM6Ly9mdW5kaW5nY2hvaWNlc21lc3NhZ2VzLmdvb2dsZS5jb20vZi9BR1NLV3hXZUlPV0JzcG1VdkpxdThFTUw0STdscDZoc2paMDNkeUNYbkVFR0RKZDJ5dTFia3QxUXlMVVM5clJOV0M5M21KNkFMWHE5eVF1TzJPTnl6UXZ0bUFcdTAwM2RcdTAwM2QiXQosWzIwLCJkaXYtZ3B0LWFkIiwxMDAsIk9UY3dOR0ZsTVdWaVltRmtPV1JpIixbbnVsbCxudWxsLG51bGwsImh0dHBzOi8vd3d3LmdzdGF0aWMuY29tLzBlbW4vZi9wLzk3MDRhZTFlYmJhZDlkYi5qcz91c3FwXHUwMDNkQ0FzIl0KXQosImh0dHBzOi8vZnVuZGluZ2Nob2ljZXNtZXNzYWdlcy5nb29nbGUuY29tL2wvQUdTS1d4WC0wd2RHX3ZNdEx2LTc1cTRfTVdMSFJJdnktMHZMNFpESU1fNGZhZ0poMGUxc1ZqSDh6cjhjQmNBQmhBVGJ0cW8tbEpLWXJVaGlVZlk5a1ZrXHUwMDNkP2FiXHUwMDNkMSIsImh0dHBzOi8vZnVuZGluZ2Nob2ljZXNtZXNzYWdlcy5nb29nbGUuY29tL2wvQUdTS1d4VXUzZDUxVnpfOU1mVFFmbmIxeXl1SlkycUkzTG8xWTNyVnl0eW9iSHJwdHlwTnR6QV9rNDZuMjhZTFJwclVnZmJqSWxfelk0ZlNhbFAwejJnXHUwMDNkP2FiXHUwMDNkMlx1MDAyNnNiZlx1MDAzZDEiLCJodHRwczovL2Z1bmRpbmdjaG9pY2VzbWVzc2FnZXMuZ29vZ2xlLmNvbS9sL0FHU0tXeFc0QjJjQ2RPYkVZNy1QRjVia0JfM0pkRWhTREcxSXYwSy1LdThZdktNbmJTeWVIX09JaHNZaTdHWm9GUnVRcjROSlFzVm9ydkVPUGkxN3BSY1x1MDAzZD9zYmZcdTAwM2QyIl0K");</script>



<!-- Markup JSON-LD dibuat oleh Pemandu Markup Data Terstruktur Google. -->
<script type="application/ld+json">
{
  "@context" : "http://schema.org",
  "@type" : "Website",
  "image" : [ "/uploads/images/ce5140df15d046a66883807d18d0264b.webp", "/uploads/images/021bbc7ee20b71134d53e20206bd6feb.webp", "/uploads/images/82b8a3434904411a9fdc43ca87cee70c.webp", "/uploads/images/24146db4eb48c718b84cae0a0799dcfc.webp", "/uploads/images/ef50c335cca9f340bde656363ebd02fd.webp", "/uploads/images/03e0704b5690a2dee1861dc3ad3316c9.webp", "/uploads/images/0768281a05da9f27df178b5c39a51263.webp", "/uploads/images/93d65641ff3f1586614cf2c1ad240b6c.webp", "/uploads/images/3806734b256c27e41ec2c6bffa26d9e7.webp", "/uploads/images/84d2004bf28a2095230e8e14993d398d.webp", "/uploads/images/e515df0d202ae52fcebb14295743063b.webp", "/uploads/images/afdec7005cc9f14302cd0474fd0f3c96.webp", "/uploads/images/aba3b6fd5d186d28e06ff97135cade7f.webp", "/uploads/images/c8ed21db4f678f3b13b9d5ee16489088.webp", "/uploads/images/08419be897405321542838d77f855226.webp", "/uploads/images/7f1171a78ce0780a2142a6eb7bc4f3c8.webp", "/uploads/images/1700002963a49da13542e0726b7bb758.webp", "/uploads/images/53c3bce66e43be4f209556518c2fcb54.webp", "/uploads/images/6883966fd8f918a4aa29be29d2c386fb.webp", "/uploads/images/dc912a253d1e9ba40e2c597ed2376640.webp" ]
}
</script>

<?
header('Content-Type: text/html; charset=utf-8');
$host = $_SERVER['HTTP_HOST'];
setlocale(LC_TIME, "id_ID");
date_default_timezone_set('Asia/Jakarta');

$startdir = '.';
$showthumbnails = false;
$showdirs = true;
$forcedownloads = false;
$hide = array(
    'dlf',
    'public_html',
    'index.php',
    'Thumbs',
    '.htaccess',
    '.htpasswd'
);
$displayindex = false;
$allowuploads = false;
$overwrite = false;

$indexfiles = array(
    'index.html',
    'index.htm',
    'default.htm',
    'default.html'
);

$filetypes = array(
    'png' => 'jpg.gif',
    'jpeg' => 'jpg.gif',
    'bmp' => 'jpg.gif',
    'jpg' => 'jpg.gif',
    'gif' => 'gif.gif',
    'zip' => 'archive.png',
    'rar' => 'archive.png',
    'exe' => 'exe.gif',
    'setup' => 'setup.gif',
    'txt' => 'text.png',
    'htm' => 'html.gif',
    'html' => 'html.gif',
    'php' => 'php.gif',
    'fla' => 'fla.gif',
    'swf' => 'swf.gif',
    'xls' => 'xls.gif',
    'doc' => 'doc.gif',
    'sig' => 'sig.gif',
    'fh10' => 'fh10.gif',
    'pdf' => 'pdf.gif',
    'psd' => 'psd.gif',
    'rm' => 'real.gif',
    'mpg' => 'video.gif',
    'mpeg' => 'video.gif',
    'mov' => 'video2.gif',
    'avi' => 'video.gif',
    'eps' => 'eps.gif',
    'gz' => 'archive.png',
    'asc' => 'sig.gif',
);

error_reporting(0);
if (!function_exists('imagecreatetruecolor')) $showthumbnails = false;
$leadon = $startdir;
if ($leadon == '.') $leadon = '';
if ((substr($leadon, -1, 1) != '/') && $leadon != '') $leadon = $leadon . '/';
$startdir = $leadon;

if ($_GET['dir']) {
    // check this is okay.

    if (substr($_GET['dir'], -1, 1) != '/') {
        $_GET['dir'] = $_GET['dir'] . '/';
    }

    $dirok = true;
    $dirnames = split('/', $_GET['dir']);
    for ($di = 0; $di < sizeof($dirnames); $di++) {

        if ($di < (sizeof($dirnames) - 2)) {
            $dotdotdir = $dotdotdir . $dirnames[$di] . '/';
        }

        if ($dirnames[$di] == '..') {
            $dirok = false;
        }
    }

    if (substr($_GET['dir'], 0, 1) == '/') {
        $dirok = false;
    }

    if ($dirok) {
        $leadon = $leadon . $_GET['dir'];
    }
}


$opendir = $leadon;
if (!$leadon) $opendir = '.';
if (!file_exists($opendir)) {
    $opendir = '.';
    $leadon = $startdir;
}

clearstatcache();
if ($handle = opendir($opendir)) {
    while (false !== ($file = readdir($handle))) {
        // first see if this file is required in the listing
        if ($file == "." || $file == "..") continue;
        $discard = false;
        for ($hi = 0; $hi < sizeof($hide); $hi++) {
            if (strpos($file, $hide[$hi]) !== false) {
                $discard = true;
            }
        }

        if ($discard) continue;
        if (@filetype($leadon . $file) == "dir") {
            if (!$showdirs) continue;

            $n++;
            if ($_GET['sort'] == "date") {
                $key = @filemtime($leadon . $file) . ".$n";
            } else {
                $key = $n;
            }
            $dirs[$key] = $file . "/";
        } else {
            $n++;
            if ($_GET['sort'] == "date") {
                $key = @filemtime($leadon . $file) . ".$n";
            } elseif ($_GET['sort'] == "size") {
                $key = @filesize($leadon . $file) . ".$n";
            } else {
                $key = $n;
            }
            $files[$key] = $file;

            if ($displayindex) {
                if (in_array(strtolower($file), $indexfiles)) {
                    header("Location: $file");
                    die();
                }
            }
        }
    }
    closedir($handle);
}

// sort our files
if ($_GET['sort'] == "date") {
    @ksort($dirs, SORT_NUMERIC);
    @ksort($files, SORT_NUMERIC);
} elseif ($_GET['sort'] == "size") {
    @natcasesort($dirs);
    @ksort($files, SORT_NUMERIC);
} else {
    @natcasesort($dirs);
    @natcasesort($files);
}

// order correctly
if ($_GET['order'] == "desc" && $_GET['sort'] != "size") {
    $dirs = @array_reverse($dirs);
}
if ($_GET['order'] == "desc") {
    $files = @array_reverse($files);
}
$dirs = @array_values($dirs);
$files = @array_values($files);

?>


<?= html_entity_decode(base64_decode($this->settings['site_google_analytics'])) ?>

<?php compileScss(); ?>

<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
<link rel="alternate" href="<?= base_url() ?>" hreflang="en-id">
<link rel="icon" href="<?=  base_url("assets/images/{$this->settings['site_favicon']}") ?>">
<meta name="robots" content="<?= $this->settings['site_robots'] ?>">
<meta name="google-site-verification" content="<?= $this->settings['site_google_verification_code'] ?>">
<meta name="yandex-verification" content="<?= $this->settings['site_yandex_verification_code'] ?>">
<meta name="msvalidate.01" content="<?= $this->settings['site_bing_verification_code'] ?>">

<link rel="canonical" href="https://www.berpedia.com/" />

<meta property='article:author' content="100053413245030">
<meta property='article:publisher' content='https://www.facebook.com/100053413245030">
<meta property='fb:admins' content="https://www.facebook.com/bianity">
<meta content='Kreator, Kontributor, Daftar Kontributor, Join Kontributor, Freelancer, Belajar Nulis, Nulis Catatan, Berita, Sosial Media, Platform Media' property='article:tag' />
<meta content='Platform Stori' property='og:image:alt' />
<meta content='https://www.berpedia.com/page/ketentuan' property='ia:markup_url' />
<meta content='https://www.berpedia.com/page/privasi' property='ia:rules_url_dev' />
<meta content='https://www.berpedia.com/page/pedoman-media-siber' property='ia:rules_url' />
<meta content='https://www.berpedia.com/page/bantuan' property='ia:markup_url_dev' />

<meta content='https://www.facebook.com/100053413245030' property='article:author'/>
<meta content='https://www.facebook.com/100053413245030' property='article:publisher'/>
<meta content='100053413245030' property='fb:admins'/>
<meta content='393750998258649' property='fb:app_id'/>
<meta content='en_US' property='og:locale'/>
<meta content='en_GB' property='og:locale:alternate'/>
<meta content='id_ID' property='og:locale:alternate'/>

<meta content='Stori' name="Author" />
<link href="https://www.facebook.com/medialovacom" rel="me" />
<link href="https://www.facebook.com/medialovacom" rel="author" />
<link href="https://www.facebook.com/medialova" rel="publisher" />
<meta content='Stori' property="article:author" />

<meta property='fb:pages' content="102517824921619" />
<meta property='fb:app_id' content="393750998258649">
<meta name="description" content="<?= $metadata->description ?>">
<meta name="keywords" content="<?= $metadata->keywords ?>">
<meta name="author" content="<?= $metadata->author ?>">
<meta name='rating' content='<?= $metadata->rating ?>'>
<meta name='date' content='<?= $metadata->date ?>'>

<meta property="og:site_name" content="<?= $metadata->site_name ?>">
<meta property="og:title" content="<?= $metadata->title ?>">
<meta property="og:type" content="<?= $metadata->type ?>">
<meta property="og:url" content="<?= $metadata->url ?>">
<meta property="og:description" content="<?= $metadata->description ?>">
<meta property="og:image" content="<?= $metadata->image ?>">

<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="<?= $metadata->title ?>">
<meta name="twitter:url" content="<?= $metadata->url ?>">
<meta name="twitter:description" content="<?= $metadata->description ?>">
<meta name="twitter:site" content="<?= $metadata->site_name ?>">
<meta name="twitter:image" content="<?= $metadata->image ?>">
<meta name="twitter:creator" content="@medialova">

<meta itemprop="title" content="<?= $metadata->title ?>">
<meta itemprop="name" content="<?= $metadata->site_name ?>">
<meta itemprop="url" content="<?= $metadata->url ?>">
<meta itemprop="description" content="<?= $metadata->description ?>">
<meta itemprop="image" content="<?= $metadata->image ?>">

<title><?= $metadata->title ?></title>

<meta name='dmca-site-verification' content='QklvWHpDSEpDYnpMeHRRc2xyRFVrZmUvcTlWMUFKR0xlMTZvZ2dYMDVyYz01' />
<meta name="norton-safeweb-site-verification" content="zsppa70fqsc6qwmr95slsdixmvxze79dvq3rzdxgf8rjyoqn03byvm2ysphxgbl12bf2dj466prno9p545odsng7ig1tnovf8ras5voiyqfl3d5x-c79gnvu3cu1bkli" />

<?= html_entity_decode(base64_decode($this->settings['site_auto_ads'])) ?>

<?= html_entity_decode(base64_decode($this->settings['site_popup_code'])) ?>


<!-- JQUERY -->
<script rel="preload" src="<?= base_url("assets/libraries/jquery-3.3.1/jquery.min.js"); ?>"></script>

<!-- JQUERY UI -->
<script defer src="<?= base_url("assets/plugins/jquery-ui.min-1.12.0.js"); ?>"></script>


<!-- SEMANTIC-UI -->
<link rel="stylesheet" rel="preload" rel="import" href="<?= base_url("assets/frameworks/Semantic-UI-CSS-master/semantic.min.css"); ?>" media="all">
<script defer src="<?= base_url("assets/frameworks/Semantic-UI-CSS-master/semantic.min.js"); ?>"></script>

<link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/slick-carousel/slick.min.css') ?>" media="all"/>
<script defer src="<?= base_url('assets/plugins/slick-carousel/slick.min.js') ?>"></script>

<!--FONT SAYA-STORI -->


<!-- JS -->
<script rel="preload" src="<?= base_url("assets/js/app.js") ?>"></script>

<?php
	$style = get_cookie('style') 
			 ?? $this->settings['site_style'] 
			 ?? 'light';
?>

<!-- CSS -->

<link rel="stylesheet" href="<?= base_url("assets/css/opoin_{$style}.css") ?>" media="all">
<link rel="stylesheet" href="<?= base_url("assets/css/spacing.css") ?>" media="all">
<link id="scrollbar" rel="stylesheet" href="<?= base_url("assets/css/scrollbar.css") ?>" media="all">
<link rel="stylesheet" href="<?= base_url("assets/css/melovers.css") ?>" media="all">
<link rel="stylesheet" href="<?= base_url("assets/css/download.css") ?>" media="all">

    

<script type="text/javascript">
function Getcopylink() {
    var body = document.getElementsByTagName('body')[0];
    var selection_area;
    selection_area = window.getSelection();
    var copyright_content = "<br /><br /> PENTING!!! Harap mencantumkan sumber Artikel kami.<br /><br /> Sumber Artikel ini telah tayang di: "+document.location.href+" &copy Nando.it"; // hak cipta ini dibuat oleh Stori
    var copyingtext = selection_area + copyright_content;
    var newdiv = document.createElement('div');
    newdiv.style.position='absolute';
    newdiv.style.left='-99999px';
    body.appendChild(newdiv);
    newdiv.innerHTML = copyingtext;
    selection_area.selectAllChildren(newdiv);
    window.setTimeout(function() {
        body.removeChild(newdiv);
    },0);
}
document.oncopy = Getcopylink;
</script>

<script type='text/javascript'>
//<![CDATA[
$(document).ready(function(){$.wmBox()}),function(o){o.wmBox=function(){o("body").prepend('<div class="wmBox_overlay"><div class="wmBox_centerWrap"><div class="wmBox_centerer">')},o("[data-popup]").click(function(e){e.preventDefault(),o(".wmBox_overlay").fadeIn(750);var a=o(this).attr("data-popup");o(".wmBox_overlay .wmBox_centerer").html('<div class="wmBox_contentWrap"><div class="wmBox_scaleWrap"><div class="wmBox_closeBtn"><p>x</p></div><iframe src="'+a+'">'),o(".wmBox_overlay iframe").click(function(o){o.stopPropagation()}),o(".wmBox_overlay").click(function(e){e.preventDefault(),o(".wmBox_overlay").fadeOut(750)})})}(jQuery);
//]]>
</script>


<script type="text/javascript">
                        
        $(function () {
            let fireworksDraw = false;
            const TARGET_ELEMENT = "#RibbonFall";
            const RibbonBG = document.querySelector(TARGET_ELEMENT);

            setInterval(() => {
                confetti( {
                    x: RibbonBG.clientWidth / 2,
                    y: 200
                },
            TARGET_ELEMENT
        );
        }, 6500);

            function confetti(t, e) {
                var i = document.querySelector(e || "body"),
                    n =
                        window.requestAnimationFrame ||
                        window.webkitRequestAnimationFrame ||
                        window.mozRequestAnimationFrame ||
                        window.oRequestAnimationFrame ||
                        window.msRequestAnimationFrame ||
                        function(t) {
                            window.setTimeout(t, 1e3 / 60);
                        },
                    a = {
                        particleCount: 50,
                        angle: 90,
                        spread: 100,
                        startVelocity: 25,
                        decay: 0.9,
                        ticks: 150,
                        zIndex: 100,
                        colors: [
                            "#5BC0EB", "#2176AE", "#FDE74C", "#9BC53D", "#E55934", "#FA7921", "#FF4242"
                        ]
                    },
                    s = void 0;

                function o(t) {
                    return parseInt(t, 16);
                }
                function r(t, e, i) {
                    return (function(t, e) {
                        return e ? e(t) : t;
                    })(
                        t &&
                        (function(t) {
                            return !(null === t || void 0 === t);
                        })(t[e])
                            ? t[e]
                            : a[e],
                        i
                    );
                }

                function c(t) {
                    var e = t.getContext("2d"),
                        i = window.devicePixelRatio || 1,
                        n =
                            e.webkitBackingStorePixelRatio ||
                            e.mozBackingStorePixelRatio ||
                            e.msBackingStorePixelRatio ||
                            e.oBackingStorePixelRatio ||
                            e.backingStorePixelRatio ||
                            1,
                        a = i / n;
                    (t.width = document.documentElement.clientWidth * a),
                        (t.height = document.documentElement.clientHeight * a),
                        (t.style.width = document.documentElement.clientWidth + "px"),
                        (t.style.height = document.documentElement.clientHeight + "px");
                }

                function l(t) {
                    var e = t.angle * (Math.PI / 180),
                        i = t.spread * (Math.PI / 180);
                    return {
                        x: t.x,
                        y: t.y,
                        depth: 0.5 * Math.random() + 0.6,
                        wobble: 10 * Math.random(),
                        velocity: 0.5 * t.startVelocity + Math.random() * t.startVelocity,
                        angle2D: -e + (0.5 * i - Math.random() * i),
                        tiltAngle: Math.random() * Math.PI,

                        color: (function(t) {
                            var e = (t + "").replace(/[^0-9a-f]/gi, "");
                            return (
                                e.length < 6 && (e = e[0] + e[0] + e[1] + e[1] + e[2] + e[2]),
                                    {
                                        r: o(e.substring(0, 2)),
                                        g: o(e.substring(2, 4)),
                                        b: o(e.substring(4, 6))
                                    }
                            );
                        })(t.color),
                        tick: 0,
                        totalTicks: t.ticks,
                        decay: t.decay,
                        random: Math.random() + 5,
                        tiltSin: 0,
                        tiltCos: 0,
                        wobbleX: 0,
                        wobbleY: 0
                    };
                }

                function u(t, e, i) {
                    function a() {
                        r = l = null;
                    }
                    var s = e.slice(),
                        o = t.getContext("2d"),
                        r = parseInt(t.style.width, 10),
                        l = parseInt(t.style.height, 10);
                    o.save(),
                        o.scale(t.width / r, t.height / l);

                    var u = new Promise(function(e) {

                        n(function u() {
                            r ||
                            l ||
                            (c(t),
                                (r = parseInt(t.style.width, 10)),
                                (l = parseInt(t.style.height, 10)),
                                o.restore(),
                                o.scale(t.width / r, t.height / l)),
                                o.clearRect(0, 0, r, l),
                                (s = s.filter(function(t) {
                                    return (function(t, e) {
                                        (e.x += Math.cos(e.angle2D) * e.velocity),
                                            (e.y += Math.sin(e.angle2D) * e.velocity + 5 * e.depth),
                                            (e.wobble += 0.1),
                                            (e.velocity *= e.decay),
                                            (e.tiltAngle += 0.02 * Math.random() + 0.12),
                                            (e.tiltSin = Math.sin(e.tiltAngle)),
                                            (e.tiltCos = Math.cos(e.tiltAngle)),
                                            (e.random = Math.random() + 4),
                                            (e.wobbleX = e.x + 10 * Math.cos(e.wobble) * e.depth),
                                            (e.wobbleY = e.y + 10 * Math.sin(e.wobble) * e.depth);
                                        var i = e.tick++ / e.totalTicks,
                                            n = e.x + e.random * e.tiltCos,
                                            a = e.y + e.random * e.tiltSin,
                                            s = e.wobbleX + e.random * e.tiltCos,
                                            o = e.wobbleY + e.random * e.tiltSin;
                                        return (
                                            (t.fillStyle =
                                                "rgba(" +
                                                e.color.r +
                                                ", " +
                                                e.color.g +
                                                ", " +
                                                e.color.b +
                                                ", " +
                                                (1 - i) +
                                                ")"),
                                                t.beginPath(),
                                                e.depth,
                                                t.moveTo(Math.floor(e.x), Math.floor(e.y)),
                                                t.lineTo(Math.floor(e.wobbleX), Math.floor(a)),
                                                t.lineTo(Math.floor(s), Math.floor(o)),
                                                t.lineTo(Math.floor(n), Math.floor(e.wobbleY)),
                                                t.closePath(),
                                                t.fill(),
                                            e.tick < e.totalTicks
                                        );
                                    })(o, t);
                                })),
                                s.length ? n(u) : (window.removeEventListener("resize", a), i(), e());
                        });
                    });
                    return (
                        window.addEventListener("resize", a, !1),
                            {
                                addFettis: function(t) {
                                    return (s = s.concat(t)), u;
                                },
                                canvas: t,
                                promise: u
                            }
                    );
                }
                fireworksDraw ||
                ((window.fireworksDraw = !0),
                i &&
                (function(t, i) {
                    for (
                        var n = "fireCanvas",
                            a = r(i, "particleCount", Math.floor),
                            o = r(i, "angle", Number),
                            d = r(i, "spread", Number),
                            f = r(i, "startVelocity", Number),
                            h = r(i, "decay", Number),
                            p = r(i, "colors"),
                            m = r(i, "ticks", Number),
                            v = r(i, "zIndex", Number),
                            b = (function(t) {
                                var e = r(t, "origin", Object);
                                console.log("func b => e:", e);
                                console.log("func b => t:", t);
                                return (e.x = r(e, "x", Number)), (e.y = r(e, "y", Number)), e;
                            })(i),
                            y = a,
                            g = [],
                            I = s
                                ? s.canvas
                                : (function(t) {
                                    var e = document.querySelector("#" + n);
                                    return (
                                        e
                                            ? (e.update = !0)
                                            : ((e = document.createElement("canvas")), (e.id = n)),
                                            c(e),
                                            (e.style.position = "fixed"),
                                            (e.style.top = "0px"),
                                            (e.style.left = "0px"),
                                            (e.style.pointerEvents = "none"),
                                            (e.style.zIndex = t),
                                            e
                                    );
                                })(v),
                            k = b.x,
                            w = b.y;
                        y--;

                    )
                        g.push(
                            l({
                                x: k,
                                y: w,
                                angle: o,
                                spread: d,
                                startVelocity: f,
                                color: p[y % p.length],
                                ticks: m,
                                decay: h
                            })
                        );
                    s
                        ? s.addFettis(g)
                        : (!I.update && t.appendChild(I),
                            (s = u(I, g, function() {
                                (s = null),
                                    (e = document.querySelector("#" + n)),
                                e && t.removeChild(e),
                                    (fireworksDraw = !1);
                            })).promise);
                })(i, {
                    particleCount: 150,
                    startVelocity: 45,
                    origin: t
                }));
            }
        });
</script>