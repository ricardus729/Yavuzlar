function appendSoru(soruArr) {

    const soru0 = { 
        soru: soruArr[0], 
        siklar: [soruArr[1],soruArr[2],soruArr[3],soruArr[4]], 
        zorluk: soruArr[5], 
        dogru: soruArr[6] 
    };

    let sorular = JSON.parse(localStorage.getItem('sorular')) || [];
    sorular.push(soru0);


    try {

         localStorage.setItem('sorular', JSON.stringify(sorular));

    } catch (error) {
        alert(error);
    }

}

function sil(soruIndex){


    if(localStorage.key(soruIndex) == null)
        return;

    localStorage.removeItem(localStorage.key(soruIndex));
  
    location.href = "./list.html"

}

function editSoru(id, data){

    sil(id);
    appendSoru(data);

}


function getRndInteger(min, max) {
    return Math.floor(Math.random() * (max - min) ) + min;
  }

let pasifSorular = [];

function answer(id, answer){
    
    let sorular = JSON.parse(localStorage.getItem('sorular')) || [];
    
    soru = sorular[id];

    correct = soru["dogru"];


    if(correct == answer){
        
        let points = parseInt(localStorage.getItem("points"));
        points += parseInt(soru["zorluk"] * 5);
        localStorage.setItem("points", points.toString());
        document.getElementById("points").innerHTML = "Puan: " + points.toString();

        pasifSorular.push(id);

        getSoru(-1);
    }else if(answer === -1){
        
        pasifSorular.push(id);

        getSoru(-1);
    }

}

function getSoru(id){

    let soruContainer = document.getElementById("soruContainer");
    if(!Object.is(soruContainer, null)){


        document.getElementById("points").innerHTML = "Puan: " + localStorage.getItem("points");


        
        let sorular = JSON.parse(localStorage.getItem('sorular')) || [];

        let soru;
    
        soru = sorular[id];

        let puan = localStorage.getItem("points");
    
        if(pasifSorular.length === sorular.length){
            localStorage.setItem("points", "0");
            let str0 = "Bütün soruları gördün! Puan: " + puan.toString();
            alert(str0);
            location.href = "./index.html";
            return;
        }
    
        if(sorular[id] == undefined){
            id =  getRndInteger(0, localStorage.length + 1);
            return getSoru(id);
        }

        if(pasifSorular.includes(id))
            return getSoru(-1);


        data = "";
        data += `<h2>${soru["soru"]}</h2>`;
        data += `<button onclick='answer(${id}, "a")'>A: ${soru["siklar"][0]}</button>`;
        data += `<button onclick='answer(${id}, "b")'>B: ${soru["siklar"][1]}</button>`;
        data += `<button onclick='answer(${id}, "c")'>C: ${soru["siklar"][2]}</button>`;
        data += `<button onclick='answer(${id}, "d")'>D: ${soru["siklar"][3]}</button>`;
        data += `<button style='width:30%;' onclick='answer(${id}, -1)'>Soruyu Geç</button>`;

        soruContainer.innerHTML = data;
    }   

}

window.onload = function() {



    if(localStorage.getItem("points") === null){

        localStorage.setItem("points", "0");
    }


    let adminListe = document.getElementById("soruListesiAdmin");
    if(!Object.is(adminListe, null)){
        let data = "<tr>" +
          "<th>Soru</th>" +
          "<th>Sil</th>" +
          "<th>Düzenle</th>" +
        "</tr>";
        let sorular = JSON.parse(localStorage.getItem('sorular')) || [];
        sorular.forEach((element, index) => {
            console.log(sorular.getItem)
            data = data + "<tr><td>" + element["soru"] + "</td><td><button onclick='sil(" +  index + ")'>Sil</button></td><td><a href='edit.html?id=" +  index + "'>Duzenle</a></td></tr>";
        });

             
        adminListe.innerHTML = data;

    }   


    getSoru(-1);



};



let form = document.getElementById("form");
if(!Object.is(form, null)){
form.addEventListener("submit", function (e) {
    e.preventDefault();
  
    const urlParams = new URLSearchParams(window.location.search);
    const id = parseInt(urlParams.get('id'));

    const promise1 = new Promise((resolve, reject) => {
        let soru = document.getElementsByName('soru')[0].value;
        let a = document.getElementsByName('a')[0].value;
        let b = document.getElementsByName('b')[0].value;
        let c = document.getElementsByName('c')[0].value;
        let d = document.getElementsByName('d')[0].value;
        let zorluk = document.getElementsByName('zorluk')[0].value;
        let dogru = document.getElementsByName('dogru')[0].value;
        let action = document.getElementsByName('action')[0].value;

        if(action == "add"){
            appendSoru([soru, a, b, c, d, zorluk, dogru]);
        }else{    
            editSoru(id, [soru, a, b, c, d, zorluk, dogru]);
        }


        location.href="list.html";
        resolve('Success!');
      });
      

  });
}