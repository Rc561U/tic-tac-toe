
// Create new username 
const form = document.getElementById('example_form');

function doing(){
	form.addEventListener('submit', function(e) {
    // Prevent default behavior:
		e.preventDefault();
		// Create payload as new FormData object:
		const payload = new FormData(form);
		fetch('php/insert_db.php', {
			method: 'POST',
			body: payload,
			})
		.then(res => res.json())
		.then(data => {
			var errore = document.getElementById('error')
			if (data.status === 'true') {
							errore.innerHTML= `<div class="alert alert-success" role="alert">
				  													${data.response}
																</div>`
			}else{errore.innerHTML= `<div class="alert alert-danger" role="alert">
																  ${data.response}
																</div>`
															}
			
			console.log(data)});

		update()
	updateLeftPanel()
	    
	})
}


function update(){
	fetch('php/select_all_db.php', {
		method : 'GET'
	})
	.then(response => response.json())
	.then(result => {
		let element = document.getElementById("insertTable");
		while (element.firstChild) {
		  element.removeChild(element.firstChild);
		}

		var table = document.getElementById("dashboard_table");
		const tbodyEl = document.getElementById("insertTable");

		for (var i = 0; i < 10; i++) {
		    
		    let row  = document.createElement("tr")


		    row.innerHTML += `
		                <tr id="rem">
		                    <th scope="row">${i+1}</th>
		                    <td>${result[i]['name']}</td>
		                    <td>${result[i]['score']}</td>
		                    
		                </tr>
		            `;
		    document.getElementById('insertTable').appendChild(row)
		}
		//
		
		
	})
}


function updateLeftPanel(){
	fetch('php/score_getter.php', {
		method : 'GET',
		// body: JSON.stringify({'username' : datasas}),

	})
	.then(response => response.json())
	.then(result => {
		
		let element = document.getElementById("insertTable2");
		while (element.firstChild) {
		  element.removeChild(element.firstChild);
		}

		var table = document.getElementById("dashboard_table2");
		const tbodyEl = document.getElementById("insertTable2");

		for (var i = 0; i < 1; i++) {
		    
		    let row  = document.createElement("tr")


		    row.innerHTML += `
		                <tr id="rem">
		                    <th scope="row">${i+1}</th>
		                    <td>${result['name']}</td>
		                    <td>${result['games']}</td>
		                    <td>${result['wins']}</td>
		                    <td>${result['draw']}</td>
		                    <td>${result['loses']}</td>
		                    <td>${result['score']}</td>
		                    
		                </tr>
		            `;
		    document.getElementById('insertTable2').appendChild(row)
		}
		
		
		
	})
}
update()
updateLeftPanel()
doing()

async function sendScoreToBackend(win,lose) {
  const object = { 'wins': win, 'lose' : lose };
  //console.log(object)
  const response = await fetch('php/take_score.php', {
    method: 'POST',
    body: JSON.stringify(object),
    headers: {
      'Content-Type': 'application/json'
  	}
  });
  const responseText = await response.text();
  //console.log(responseText); // logs 'OK'
}



$(document).ready(function () {
    $("#restartGame").click(function () {
        location.reload(true);
    });
});


function getAlert(combo){
	var gameResult = document.getElementById('gameResult')
	if (combo === 'xxx') {
		
		gameResult.innerHTML = `<div class="alert alert-info" role="alert">
  														You Win! +1 score
														</div>`
		sendScoreToBackend(1,0);
		
		// location.reload(true);
	}else if ( combo === 'ooo'){
		gameResult.innerHTML = `<div class="alert alert-warning" role="alert">
  														You Lose =( -1 score
														</div>`
		sendScoreToBackend(0,1);
		// console.log("From getAlert 0, 1")
		// location.reload(true);
	}else {
		gameResult.innerHTML = `<div class="alert alert-secondary" role="alert">
  														Draw
														</div>`
		sendScoreToBackend(0,0);
	}
}


// tictac
function openForm() {
  document.getElementById("myForm").style.display = "block";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
} 


var stop = false

var arrData = document.querySelectorAll("[data-num]")
var url = 'bot.php';
// var arr = [null, null, null, null, null, null, null, null, null]
var arr = ['null', 'null','null','null','null','null','null','null','null']
let data = {'data' : arr}
var concat = function(a, b, c){
	var result = arr[a] + arr[b] + arr[c] 
	
	if (result === "xxx" || result === "ooo"){
		return result
	}
	
	switch (result){
		case "xxnull":
			return ["x", c]
			
		case "xnullx":
			return ["x", b]
			
		case "nullxx":
			return ["x", a]
			
		case "oonull":
			return ["o", c]
			
		case "onullo":
			return ["o", b]
			
		case "nulloo":
			return ["o", a]
	}
}

var changeColorAndStop = function(a, b, c){
	arrData[a].style.color = "red"
	arrData[b].style.color = "red"
	arrData[c].style.color = "red"
	
	stop = true
}







var checkWin = function(){
	for (var i = 0; i < 3; i++){
		var result = concat(i, i + 3, i + 6)
		
		if (result === "xxx" || result === "ooo"){
			changeColorAndStop(i, i + 3, i + 6)
			getAlert(result)
		}
	}
	
	for (var i = 0; i <= 6; i +=3){
		var result = concat(i, i + 1, i + 2)
		
		if (result === "xxx" || result === "ooo"){
			changeColorAndStop(i, i + 1, i + 2)
			getAlert(result)
		}
	}
	
	result = concat(0, 4, 8)
	if (result === "xxx" || result === "ooo"){
		changeColorAndStop(0, 4, 8)
		getAlert(result)
	}
	
	result = concat(2, 4, 6)
	if (result === "xxx" || result === "ooo"){
		changeColorAndStop(2, 4, 6)
		getAlert(result)
	}	


	
}



addEventListener("click", function(event){
	if (stop === true){return}
	
	if (event.target.className === "cell" && event.target.textContent === ""){
		event.target.style.color = "blue"
		event.target.innerHTML = "x"
		
		arr[event.target.dataset.num] = "x"
		
		//console.log (arr)
		
	}else{
		return
	}
	checkWin()
	
	if (stop === true){return}


	fetch(url, {
		method : 'POST',
		body: JSON.stringify({'jsonData' : data}),
		headers : { 'Content-type' : 'application/json;charset=utf-8'}
	})
	.then(response => response.text())
	.then(result => {
		
		
		arrData[result].innerHTML = "o"
		arr[result] = "o"
		checkWin()
		console.log(arr.filter(x => x== 'null').length)
		
		if (arr.filter(x => x== 'null').length == '1'){
			getAlert('draw')
			
		}
		
		if (stop === true){

			return}
		
	})

	
})



