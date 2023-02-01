let freezeClick = false;
//Create a custom allert with customizable design
function customAlert(typeOfAlertMessage, alertMessage) {
    //Create DOM elements
    const shading = document.createElement("div");
    const alertWindow = document.createElement("div");
    const alertText = document.createElement("p");
    const closeAlert = document.createElement("span");
    const alertType = document.createElement("strong");
    //Text
    alertText.innerText = alertMessage;
    closeAlert.innerText = "X";
    //Chose alert design 
    switch (typeOfAlertMessage) {
        case 1:
            alertWindow.className = "absolute top-0 bg-[rgb(244,31,31)] text-white w-[100%] h-[5rem] text-[40px] flex flex-row";
            alertType.innerText = "Error: ";
            break;
        case 2:
            alertWindow.className = "absolute top-0 bg-[rgb(232,228,34)] text-white w-[100%] h-[5rem] text-[40px] flex flex-row";
            alertType.innerText = "Warning: ";
            break;
        case 3:
            alertWindow.className = "absolute top-0 bg-green-500 text-white w-[100%] h-[5rem] text-[40px] flex flex-row";
            alertType.innerText = "Success: ";
            break;
    }
    //Id for eacj alert element
    alertWindow.id = "alert";
    closeAlert.id = "close";
    shading.id = "darknessDungeon";
    //Design for close alert and shading div
    shading.className = "absolute bg-black opacity-25 top-20 h-[100%] w-[100%]";
    closeAlert.className = "float-right mr-[2.5rem] ml-auto text-white text-[40px] cursor-pointer"
    //Close alert
    closeAlert.addEventListener("click", function() {
        document.getElementById("alert").remove();
        document.getElementById("darknessDungeon").remove();
        freezeClick = false;
        document.addEventListener("click", handler, true);
    })
    //Connect all elements
    alertWindow.appendChild(alertType);
    alertWindow.appendChild(alertText);
    alertWindow.appendChild(closeAlert);
    document.body.appendChild(alertWindow);
    document.body.appendChild(shading);
    //Freze window
    freezeClick = true;
    document.addEventListener("click", handler, true);
}
//Frezing function
function handler(e) {
    if (freezeClick) {
        if(e.target.id!=="close") {
        e.stopPropagation()
        }
    }
}