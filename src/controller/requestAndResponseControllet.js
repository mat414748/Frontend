let requestResult = 0;
//PUT
function updateClient(id, name, surname, sex, email, creditRaiting, street, postcode, city, billingAdress, privatePhonenumber, companyPhonenumber) {
    var data = {
        Name: name,
        Surname: surname,
        Sex: sex,
        email: email,
        CreditRaiting: creditRaiting,
        Street: street,
        Postcode: postcode,
        City: city,
        billingAddress: billingAdress,
        phonenumberCompany: privatePhonenumber,
        phonenumberPrivate: companyPhonenumber,
        joinDate: Date.now(),
        VIP: 1,
        highFrequency: 1,
        creditRating: 1,
        debt: 1,
        creditcard: 4444555566667777,
        bill: "5",
        prepayment: 0
    };
    request = new XMLHttpRequest();
    request.open("PUT", "/API/v1/Client/" + id);
    request.onreadystatechange = requestCreateAndUpdate; 
    request.send(JSON.stringify(data));
}
//POST
function createClient(name, surname, sex, email, creditRaiting, street, postcode, city, billingAdress, privatePhonenumber, companyPhonenumber) {
    var data = {
        Name: name,
        Surname: surname,
        Sex: sex,
        email: email,
        CreditRaiting: creditRaiting,
        Street: street,
        Postcode: postcode,
        City: city,
        billingAddress: billingAdress,
        phonenumberCompany: privatePhonenumber,
        phonenumberPrivate: companyPhonenumber,
        joinDate: Date.now(),
        VIP: 1,
        highFrequency: 1,
        creditRating: 1,
        debt: 1,
        creditcard: 4444555566667777,
        bill: "5",
        prepayment: 0
    };
    request = new XMLHttpRequest();
    request.open("POST", "/API/v1/Client");
    request.onreadystatechange = requestCreateAndUpdate; 
    request.send(JSON.stringify(data));
}
function requestCreateAndUpdate(event) {
    if (request.readyState < 4) {
        return;
    } 
    const answer = JSON.parse(request.responseText);
    document.getElementById('clientList').click();
    customAlert(3, answer.information);
}
//DELETE
function deleteClient(id) {
    request = new XMLHttpRequest();
    request.open("DELETE", "/API/v1/Client/" + id);
    request.onreadystatechange = requestDelete; 
    request.send();
}
function requestDelete(event) { 
    if (request.readyState < 4) {
        return;
    } 
    const answer = JSON.parse(request.responseText);
    document.getElementById('clientList').click();
    customAlert(3, answer.information);
}
//GET ALL
function getAllClients() {
    request = new XMLHttpRequest();
    request.open("GET", "/API/v1/Clients");
    request.onreadystatechange = requestAnswer; 
    request.send();
}
function requestAnswer(event) { 
    if (request.readyState < 4) {
        return;
    } 
    if (JSON.parse(request.responseText).message == "Unauthorised") {
        customAlert(1, JSON.parse(request.responseText).message);
    } else {
        const mainDiv = document.getElementById("mainDiv");
        requestResult = JSON.parse(request.responseText);
        for (let i = 0; i < requestResult.length; i++) {
            mainDiv.appendChild(createTableLine(requestResult[i], i));
        }
        if (requestResult == "No clients found") {
            customAlert(2, requestResult);
        }
    }
}
//GET ONE
function getClient(id, forPermalink = 0) {
    request = new XMLHttpRequest();
    request.open("GET", "/Oneclient/" + id);
    request.onreadystatechange = function() {
        requestOne(event, id, forPermalink)
    }; 
    request.send();
}
function requestOne(event, id, forPermalink) {
    if (request.readyState < 4) {
        return;
    } 
    if (JSON.parse(request.responseText).message == "Unauthorised") {
        alert(JSON.parse(request.responseText).message);
        document.body.appendChild(helloWorld);
    } else {
        if (event.currentTarget.responseURL.includes("/levantsou-matvej/API/V1/Category")) {
            if (forPermalink == 0) {
                requestResult = JSON.parse(request.responseText).message;
                createOrUpdateTableElement(0, 1, id);
                if (requestResult == "No category found") {
                    alert(requestResult);
                }
            } else {
                requestResult = JSON.parse(request.responseText).message;
                if (requestResult == "No category found") {
                    alert(requestResult);
                    document.body.appendChild(helloWorld);
                } else {
                    createList();
                }
            }      
        } else if (event.currentTarget.responseURL.includes("/levantsou-matvej/API/V1/Product")) {
            if (forPermalink == 0) {
                requestResult = JSON.parse(request.responseText).message;
                createOrUpdateTableElement(1, 1, id);
                if (requestResult == "No product found") {
                    alert(requestResult);
                }
            } else {
                requestResult = JSON.parse(request.responseText).message;
                if (requestResult == "No product found") {
                    alert(requestResult);
                    document.body.appendChild(helloWorld);
                } else {
                    createList(1);
                }     
            }
        }
    }
}
//AUTHENTICATION
function authentication(name, password) {
    var data = {
            username: name.value,
            password: password.value
        };
    request = new XMLHttpRequest();
    request.open("POST", "/API/v1/Login");
    request.onreadystatechange = requestAuthentication; 
    request.send(JSON.stringify(data));
}
function requestAuthentication() { 
    if (request.readyState < 4) {
        return;
    } 
    const answer = JSON.parse(request.responseText);
    if (typeof answer.error !== 'undefined' && answer.error.includes("not Found")) {
        customAlert(2, "Wrong password or username");   
    } else if (answer.information == "Succesfuly created Token") {
        logout();
        customAlert(3, "Succesfully login")
        typeOfHomePage = 1;
        mainPage();
    } 
}