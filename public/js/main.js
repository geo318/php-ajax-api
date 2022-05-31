const resultDiv = document.getElementById('search_result');
const searchButton = document.getElementById('search_submit');
searchButton.addEventListener('click',loadSearchResult);

const showButton = document.getElementById('db_submit');
showButton.addEventListener('click',loadDbResult);

function spinner(element) {
// create spinner svg file
    const spinnerDiv = document.createElement('div');
    spinnerDiv.classList.add('grid', 'place-items-center', 'm-8')
    const svgSpin = document.createElementNS("http://www.w3.org/2000/svg", 'svg');
    svgSpin.classList.add('animate-spin', '-ml-1', 'h-5', 'w-5', 'text-black');
    svgSpin.setAttribute('fill',"transparent");
    svgSpin.setAttribute('viewBox',"0 0 24 24");
    const svgCircle = document.createElementNS("http://www.w3.org/2000/svg", 'circle');
    const svgPath = document.createElementNS("http://www.w3.org/2000/svg", 'path');
    svgCircle.classList.add('opacity-25');
    svgPath.classList.add('opacity-75');
    svgCircle.setAttribute('cx', '12');
    svgCircle.setAttribute('cy', '12');
    svgCircle.setAttribute('r', '10');
    svgCircle.setAttribute('stroke', 'currentColor');
    svgCircle.setAttribute('stroke-width', '4');
    svgPath.setAttribute('fill', 'currentColor');
    svgPath.setAttribute('d', 'M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z');
    
    element.appendChild(spinnerDiv);
    spinnerDiv.appendChild(svgSpin);
    svgSpin.appendChild(svgCircle);
    svgSpin.appendChild(svgPath);
// append to passed element and return
    return element
}   

function loadDbResult() {
    // sends ajax request and loads results from database
    const xhttp = new XMLHttpRequest();
    const url = "db.result.php";
    xhttp.open('POST', url, true)
    xhttp.setRequestHeader('Content-type', 'x-www-form-urlencoded');

    xhttp.onloadstart = function () {
        resultDiv.innerHTML = '';
        spinner(resultDiv);
    }
   
    xhttp.onload = function () {
        resultDiv.innerHTML = this.responseText;
    }
    xhttp.send();
}

function loadSearchResult() {
    // sends ajax request and loads single keyword data from api > database
    let post = document.getElementById('name').value;
    const xhttp = new XMLHttpRequest();
    const url = "function.php?data=" + post;
    xhttp.open('POST', url, true)
    xhttp.setRequestHeader('Content-type', 'x-www-form-urlencoded');

    xhttp.onloadstart = function () {
        resultDiv.innerHTML = '';
        spinner(resultDiv);
    }
   
    xhttp.onload = function () {
        resultDiv.innerHTML = this.responseText;
    }
    xhttp.send(post);
}
