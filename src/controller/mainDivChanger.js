let typeOfHomePage = 0;

//Assigns a function to each button on the panel
function setEvent() {
    //Homepage function
    document.getElementById("homePage").addEventListener("click", function() {
        mainPage();
    })
    //About us function
    document.getElementById("aboutUs").addEventListener("click", function() {
        aboutUsPage();
    })
    //Login and logout function
    document.getElementById("loginLogout").addEventListener("click", function() {
        switch (typeOfHomePage) {
            case 0: 
                loginWindow();
                break;
            case 1:
                logout();
                mainPage();
                break;
        }
        
    })
    //Show client list function
    document.getElementById("clientList").addEventListener("click", function() {
        createClientList();
    })
}
//After logging in, it changes the functionality and appearance of the Login button
function logout() {
    const login = document.getElementById("loginLogout");
    login.innerText = "Logout";
    document.getElementById("clientList").style.display = "block";
    //Logout onclick
    login.onclick = function() {
        document.cookie = "token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        login.innerText = "Login";
        customAlert(3,"Successfully logout");
        document.getElementById("clientList").style.display = "none";
        typeOfHomePage = 0;
        mainPage();
        //And again login
        login.onclick = function() {
            loginWindow();
        };
    }
}
//Show window on login
function loginWindow() {
    //Create all elements with DOM
    const mainDiv = document.getElementById("mainDiv");
    mainDiv.innerHTML = '';
    const title = document.createElement("div");
    const loginWindow = document.createElement("div");
    const username = document.createElement("div");
    const usernameInput = document.createElement("input");
    const password = document.createElement("div");
    const passwordInput = document.createElement("input");
    const signIn = document.createElement("div");
    //Set text for the elements
    title.innerText = "Sign in to Gruppe Rot";
    username.innerText = "Username";
    password.innerText = "Password";
    signIn.innerText = "Sign in";
    //Id for user and password inputs
    usernameInput.id = "username";
    passwordInput.id = "password";
    //Style templates  
    const inputStyle = "text-[25px] text-left w-[30rem] m-auto border-2  border-black rounded placeholder:italic placeholder:text-slate-400";
    const labelStyle = "text-[40px] text-left w-[30rem] m-auto font-bold";
    //Plaseholders for inputs
    usernameInput.placeholder = "Enter your username";
    passwordInput.placeholder = "Enter your password";
    //Design for all elements
    username.className = labelStyle;
    usernameInput.className = inputStyle;
    password.className = labelStyle + " mt-10";
    passwordInput.className = inputStyle + " mb-10";
    signIn.className = "text-[40px] text-white bg-green-500 border-2 border-black rounded w-[30rem] mb-5 pb-2 m-auto cursor-pointer";
    loginWindow.className = "border-2  border-black bg-white rounded text-center w-[35rem] m-auto";
    mainDiv.className = mainDiv.className.replace("mt-20", "mt-0"); 
    //Add function on click to "Sign in" button
    signIn.addEventListener("click", function() {
        if (document.getElementById("username").value == "") {
            customAlert(1, "Please enter the user name");
        } else if (document.getElementById("password").value == "") {
            customAlert(1, "Please enter the password");
        } else {
            authentication(usernameInput, passwordInput);
        }
    })
    //Connect all elements
    loginWindow.appendChild(username);
    loginWindow.appendChild(usernameInput);
    loginWindow.appendChild(password);
    loginWindow.appendChild(passwordInput);
    loginWindow.appendChild(signIn);
    mainDiv.appendChild(title);
    mainDiv.appendChild(loginWindow);
}
//Show main page
function mainPage() {
    //Create all elements with DOM
    const mainDiv = document.getElementById("mainDiv");
    mainDiv.innerHTML = '';
    const welcome = document.createElement("div");
    const welcomeText = document.createElement("div");
    const loginHome = document.createElement("div");
    //Login or logout type
    if (typeOfHomePage === 1) {
        welcome.innerText = "Welcome to the homepage";
        welcomeText.innerText = "Dear user, for security reasons, do \n not forget to log out after work.";
        loginHome.innerText = "Logout now";
    } else {
        welcome.innerText = "Welcome to the homepage";
        welcomeText.innerText = "Dear user, log in before \n you start working";
        loginHome.innerText = "Login now";
    }
    //Design for all elements
    welcome.className = "text-[40px] font-bold";
    welcomeText.className = "text-[40px]";
    loginHome.className = "text-[40px] bg-sky-400 border-4 border-black rounded-lg mt-5 pb-2 m-auto w-80 cursor-pointer";
    mainDiv.className = "text-center mt-20"
    //Additional login or logout button
    loginHome.addEventListener("click", function() {
        switch (typeOfHomePage) {
            case 0: 
                loginWindow();
                break;
            case 1:
                const login = document.getElementById("loginLogout");
                login.click();
                break;
        }
        
    })
    //Connect all elements
    mainDiv.appendChild(welcome);
    mainDiv.appendChild(welcomeText);
    mainDiv.appendChild(loginHome);
}
//About us page
function aboutUsPage() {
    //Create all elements with DOM
    const mainDiv = document.getElementById("mainDiv");
    mainDiv.innerHTML = '';
    const aboutGrup = document.createElement("div");
    const aboutGrupText = document.createElement("div");
    const ourTeam = document.createElement("div");
    const ourTeamText = document.createElement("div");
    //Text
    aboutGrup.innerText = "About Gruppe Rot";
    aboutGrupText.innerText = "Gruppe rot is a team of CSBE students and this site is part of their project. The aim of the project is to show our acquired skills.";
    ourTeam.innerText = "Our team";
    ourTeamText.innerText = "Our team consists of application developers and platform developers.\nApplication developers: Dominic Streit, Denis Basler, Manuel Schibli, Matvej Levantsou, Ryad Mohamed, Timoteo Muñoz Blasco \nPlatform developers: Björn Hari, Kevin Fledie, Yannis Nussbaumer. \nProject manager: Manuel Schibli";
    //Design for elements
    aboutGrup.className = "text-[50px]";
    aboutGrupText.className = "text-[25px]";
    ourTeam.className = "text-[50px]";
    ourTeamText.className = "text-[25px]";
    mainDiv.className = "text-left"
    //Connect all elements
    mainDiv.appendChild(aboutGrup);
    mainDiv.appendChild(aboutGrupText);
    mainDiv.appendChild(ourTeam);
    mainDiv.appendChild(ourTeamText);
}
//Create head for the table
function createTableHead(tableHead) {
    //Style for all tabs
    const tab = "text-[40px] text-left";
    //Full name tab
    let tableCell = document.createElement("td");
    tableCell.className = tab + " w-[20%]";
    tableCell.innerText = "Full name";
    tableHead.appendChild(tableCell);
    //Sex tab
    tableCell = document.createElement("td");
    tableCell.className = tab + " w-[10%]";
    tableCell.innerText = "Sex";
    tableHead.appendChild(tableCell);
    //Adress tab
    tableCell = document.createElement("td");
    tableCell.className = tab + " w-[25%]";
    tableCell.innerText = "Adress";
    tableHead.appendChild(tableCell);
    //E-Mail tab
    tableCell = document.createElement("td");
    tableCell.className = tab + " w-[25%]";
    tableCell.innerText = "E-mail";
    tableHead.appendChild(tableCell);
    //Dummy tab
    tableCell = document.createElement("td");
    tableCell.className = tab;
    tableCell.innerText = "";
    tableHead.appendChild(tableCell);
}
//Create new line for the table
function createTableLine(tableData, rowId) {
    //Create main elements
    const subTable = document.createElement("table");
    const tableLine = document.createElement("tr");
    const informationTable = document.createElement("div");
    //Set id for each line
    informationTable.id = "info"+rowId;
    //Subinformation statement
    let subInfoState = true;
    //Style for all tabs
    const tab = "text-[20px] text-left bg-white";
    //Full name tab
    let tableCell = document.createElement("td");
    tableCell.className = tab + " w-[20%]";
    tableCell.innerText = tableData.Name + " " + tableData.Surname;
    if (tableCell.innerText.length > 20) {
        tableCell.innerText = tableCell.innerText.slice(0, 20);
    }
    tableLine.appendChild(tableCell);   
    //Sex tab
    tableCell = document.createElement("td");
    tableCell.className = tab + " w-[10%]";
    tableCell.innerText = tableData.Sex;
    tableLine.appendChild(tableCell);  
    //Adress tab
    tableCell = document.createElement("td");
    tableCell.className = tab + " w-[25%]";
    tableCell.innerText = tableData.Street + tableData.Postcode + tableData.City;
    tableLine.appendChild(tableCell);  
    //E-Mail tab
    tableCell = document.createElement("td");
    tableCell.className = tab + " w-[25%]";
    tableCell.innerText = Object.values(tableData)[10];
    tableLine.appendChild(tableCell); 
    //Create functions for each line
    const deleteLine = document.createElement("div");
    const editLine = document.createElement("div");
    const moreInfo = document.createElement("div");
    //Set id for each subline
    moreInfo.id = rowId;
    //Text for function buttons
    deleteLine.innerText="🗑Delete";
    editLine.innerText="✏Edit";
    moreInfo.innerText="V";
    //Design for elements
    deleteLine.className = "border-2  border-black rounded pt-2 pr-1 text-red-500 cursor-pointer";
    editLine.className = "ml-5 border-2  border-black rounded pt-2 pr-1 text-orange-500 cursor-pointer";
    moreInfo.className = "ml-5 font-bold text-[30px] cursor-pointer rotate-0";
    tableLine.className = "w-auto";
    subTable.className = "m-auto w-[100%] mt-10";
    //Cell for all functions
    tableCell = document.createElement("td");
    tableCell.className = "w-auto text-[20px] text-left bg-white flex flex-row w-auto";
    //Show more information button
    moreInfo.addEventListener("click", function() {
        //If not open
        if (subInfoState) {
            moreInfo.className = moreInfo.className.replace("rotate-0", "rotate-90");;
            informationTable.appendChild(subInformation(tableData));
            subTable.after(informationTable);
            subInfoState = false;
        } 
        //If open
        else {
            moreInfo.className = moreInfo.className.replace("rotate-90", "rotate-0");
            document.getElementById("info"+moreInfo.id).innerHTML = "";
            document.getElementById("info"+moreInfo.id).remove();
            subInfoState = true;
        }
    })
    //Delete line
    deleteLine.addEventListener("click", function(event) {
        deleteClient(tableData.ID);
    })
    //Edit line
    editLine.addEventListener("click", function() {
        createOrEditClient(1, tableData);
    })
    //Connect all elements
    tableCell.appendChild(deleteLine);
    tableCell.appendChild(editLine);
    tableCell.appendChild(moreInfo);
    tableLine.appendChild(tableCell); 
    subTable.appendChild(tableLine);
    //return line
    return subTable;
}
//Show list with all clients
function createClientList() {
    //Create DOM elements
    const mainDiv = document.getElementById("mainDiv");
    mainDiv.innerHTML = '';
    const namePanel = document.createElement("div");
    const createAndSearch = document.createElement("div");
    const createClientButton = document.createElement("div");
    const searchField = document.createElement("input");
    const tableView = document.createElement("table");
    const tableHead = document.createElement("tr");
    //Create table head
    createTableHead(tableHead);
    //Placeholder for search function
    searchField.placeholder = "🔎 What are you looking for?";
    //Design for all elements
    createAndSearch.className = "flex flex-row";
    searchField.className = "ml-40 text-[25px] text-left w-[30rem] m-auto border-2  border-black rounded placeholder:italic placeholder:text-slate-400";
    namePanel.className = "text-left text-[40px] font-bold";
    createClientButton.className = "text-left text-[40px] bg-green-500 text-white border-2  border-black w-[40%] font-bold mt-5 mb-5 cursor-pointer";
    tableHead.className = "bg-teal-400 w-auto";
    tableView.className = "m-auto border-separate border-spacing-y-5 w-[100%]";
    mainDiv.className = " w-[90%] m-auto " + mainDiv.className.replace("mt-20", "mt-5");
    //Text
    namePanel.innerText = "Client manager";
    createClientButton.innerText = "+ Create new client";
    //Create new client button
    createClientButton.addEventListener("click", function() {
        createOrEditClient();
    })
    //Connect all elements
    createAndSearch.appendChild(createClientButton);
    createAndSearch.appendChild(searchField);
    tableView.appendChild(tableHead);
    mainDiv.appendChild(namePanel);
    mainDiv.appendChild(createAndSearch);
    mainDiv.appendChild(tableView);
    //Start generate lines
    generateList();
}
//Generate lines
function generateList() {
    getAllClients();
}
//On start click on mainpage
setEvent();
document.getElementById('homePage').click();