function isJson($content) {

    try {

        if (JSON.parse($content))

            return true;

    } catch (error) {}

}





function b64EncodeUnicode(str) {

    return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,

        function toSolidBytes(match, p1) {

            return String.fromCharCode('0x' + p1);

        }));

}



function b64DecodeUnicode(str) {

    return decodeURIComponent(atob(str).split('').map(function(c) {

        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);

    }).join(''));

}





function base_url(string = '')

{

    return `${location.origin}/${string}`; 

}







function url_title(string, separator = '-')

{

    return string.replace(' ', separator);

}

