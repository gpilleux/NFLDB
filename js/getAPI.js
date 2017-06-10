function getAPI(uri, process) {
	$.ajax({
		url : uri,
		async: false
	}).done(process);
}


function sendAPI(method, uri, process, dataToSend, failCallback){
	if(failCallback == null)
		failCallback = function(response){console.log(response.responseText);};
	$.ajax({
		url : uri,
		type: method,
		headers : {
			"Content-Type" : "application/json; charset=utf-8"
		},
		data: JSON.stringify(dataToSend),
		dataType : 'json',
		async: false
	}).done(process).fail(failCallback);
}
function postAPI(uri, process, dataToSend, failCallback = null) {
	sendAPI('POST', uri, process, dataToSend, failCallback);
}
function putAPI(uri, process, dataToSend, failCallback = null) {
	sendAPI('PUT', uri, process, dataToSend, failCallback);
}