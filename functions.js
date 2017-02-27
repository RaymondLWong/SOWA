function run() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'house.xml', true);

    // If specified, responseType must be empty string or "document"
    xhr.responseType = 'document';

    // overrideMimeType() can be used to force the response to be parsed as XML
    xhr.overrideMimeType('text/xml');

    xhr.onload = function () {
        if (xhr.readyState === xhr.DONE) {
            if (xhr.status === 200) {
                var content = xhr.responseXML;
                var data = content.firstChild.children;
                // console.log(data);
                var html = "";

                for (var i=0; i < data.length; i++) {
                    var temp = data[i].firstElementChild.firstChild.nodeValue; // get address

                    var house = data[i].children;
                    var rooms = 0;
                    for (var j=0; j < house.length; j++) {
                        if (house[j].nodeName === "Room") {
                            rooms++;
                        }
                    }

                    var node = `${temp} ${rooms}\r\n`;
                    html += node;
                    // var textNode = document.createTextNode(node);
                    // document.getElementById("tag").appendChild(textNode);
                }

                document.getElementById("tag").innerText = html;
            }
        }
    };

    xhr.send(null);
}
