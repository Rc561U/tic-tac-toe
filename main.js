var stop = false

var arrData = document.querySelectorAll("[data-num]")
var url = 'bot.php';
// var arr = [null, null, null, null, null, null, null, null, null]
let arr = ['null', 'null','null','null','null','null','null','null','null']
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
		}
	}
	
	for (var i = 0; i <= 6; i +=3){
		var result = concat(i, i + 1, i + 2)
		
		if (result === "xxx" || result === "ooo"){
			changeColorAndStop(i, i + 1, i + 2)
		}
	}
	
	result = concat(0, 4, 8)
	if (result === "xxx" || result === "ooo"){
		changeColorAndStop(0, 4, 8)
	}
	
	result = concat(2, 4, 6)
	if (result === "xxx" || result === "ooo"){
		changeColorAndStop(2, 4, 6)
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

	fetch(url, {
		method : 'POST',
		body: JSON.stringify({'jsonData' : data}),
		headers : { 'Content-type' : 'application/json;charset=utf-8'}
	})
	.then(response => response.text())
	.then(result => {
		console.log(result)
		arrData[result].innerHTML = "o"
		arr[result] = "o"
		checkWin()
	})
	//.catch(err=>console.error(err));

	checkWin()
	
	if (stop === true){return}

	checkWin()
	
})
