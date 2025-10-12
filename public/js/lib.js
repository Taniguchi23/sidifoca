function strip_tags(str) {
    str = str.toString();
    return str.replace(/<\/?[^>]+>/gi, '');
}

function replaceAll(string, search, replace) {
    return string.split(search).join(replace);
}

function toRadix(N, radix) {
    var HexN = "", Q = Math.floor(Math.abs(N)), R;
    while (true) {
        R = Q % radix;
        HexN = "0123456789abcdefghijklmnopqrstuvwxyz".charAt(R)
            + HexN;
        Q = (Q - R) / radix;
        if (Q == 0) break;
    }
    return ((N < 0) ? "-" + HexN : HexN);
}

function pad(width, string, padding) { 
    return (width <= string.length) ? string : pad(width, padding + string, padding)
  }