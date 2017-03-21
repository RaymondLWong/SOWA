/**
 * Create an XHR and return it
 * @param url Location to get
 * @param cb Function to handle XHR
 */
function loadFromRemoteAlternative(url, cb) {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === xhr.DONE && xhr.status === 200) {
            cb(xhr);
        }
    };
	
    xhr.send(null);
}

/**
 * source: https://www.w3schools.com/xml/xsl_client.asp
 * Display the XML search results by passing it through XSLT
 * @param xmlLoc XML file location or web service that returns XML
 * @param element The element to stick the (search result) data into
 * @param cb Function to execute after everything is complete
 */
function displayResult(xmlLoc, element, cb) {
    loadFromRemoteAlternative(xmlLoc, (xhrXML) => {
        loadFromRemoteAlternative("../common/properties.xml", (xhrXSL) => {
            let xml = xhrXML.responseXML;
            let xsl = xhrXSL.responseXML;

            // code for IE
            if (window.ActiveXObject || xhrXML.responseType == "msxml-document") {
                let ex = xml.transformNode(xsl);
                document.getElementById(element).innerHTML = ex;
            }
            // code for Chrome, Firefox, Opera, etc.
            else if (document.implementation && document.implementation.createDocument) {
                let xsltProcessor = new XSLTProcessor();
                xsltProcessor.importStylesheet(xsl);
                let resultDocument = xsltProcessor.transformToFragment(xml, document);
                document.getElementById(element).appendChild(resultDocument);
            }

            cb();
        });
    });
}

/**
 * Same as above but using JSON
 * @param url JSON file location or web service that returns JSON
 * @param element The element to stick the (search result) data into
 */
function displayResultFromJSON(url, element) {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === xhr.DONE && xhr.status === 200) {
            // console.log(`fileLoc: ${url}, element: ${element}`);
            let json = "", html = "";
            try {
                json = xhr.responseText.replace(/\n/g, ""); // remove new line characters
                json = JSON.parse(json);
                html = transformJSON(json);
            } catch (e) {
                console.error(e);
            }

            document.getElementById(element).innerHTML = html;
        }
    };
    xhr.send();
}

/**
 * Transform the source JSON into HTML that displays the results in a table format
 * @param json JS object that contains search results
 * @returns {string} HTML table that contains search results
 */
function transformJSON(json) {
    let html = `
<table>
<tr>
    <th>PropertyID</th>
    <th>Source</th>
    <th>Title</th>
    <th>Description</th>
    <th>Type</th>
    <th>Location</th>
    <th>NoOfBeds</th>
    <th>CostPerWeek</th>
    <th>Address</th>
    <th>Email</th>
    <th>PictureID</th>
</tr>\r\n
`;

    let listings = json['listings'];
    let property;
    for (let i = 0; i < listings.length; i++) {
        property = listings[i];
        html += "<tr>\r\n";

        for (let field in property) {
            if (property.hasOwnProperty(field)) {
                html += `    <td>${property[field]}</td>\r\n`;
            }
        }

        html += "</tr>\r\n";
    }
    html += "</table>\r\n";

    return html;
}