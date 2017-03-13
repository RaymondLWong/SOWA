function run() {
    let xhr = new XMLHttpRequest();
    let url = "http://localhost/SOWA/aggregate.php?title=title&desc=desc&loc=loc&addr=addr&type=&minBeds=1&maxBeds=4&minCost=1&maxCost=10000&limit=25&offset=0";
    xhr.open('GET', url, true);

    // If specified, responseType must be empty string or "document"
    xhr.responseType = 'document';

    // overrideMimeType() can be used to force the response to be parsed as XML
    xhr.overrideMimeType('text/xml');

    xhr.onload = function () {
        if (xhr.readyState === xhr.DONE) {
            if (xhr.status === 200) {
                let content = xhr.responseXML;
                let data = content.firstChild.children;
                let html = "";
                html += content.firstChild.childNodes[0].childNodes[0].nodeValue;

                for (let i=0; i < data.length; i++) {
                    // let temp = data[i].firstElementChild.firstChild.nodeValue; // get address
                    //
                    // let house = data[i].children;
                    // let rooms = 0;
                    // for (let j=0; j < house.length; j++) {
                    //     if (house[j].nodeName === "Room") {
                    //         rooms++;
                    //     }
                    // }
                    //
                    // html += `${temp} ${rooms}\r\n`;
                    // let textNode = document.createTextNode(node);
                    // document.getElementById("tag").appendChild(textNode);
                }

                document.getElementById("tag").innerText = html;
            }
        }
    };

    xhr.send(null);
}
