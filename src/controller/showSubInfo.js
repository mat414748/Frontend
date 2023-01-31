function subInformation(tableData) {
    const subTable = document.createElement("table");
    subTable.className = "m-auto w-[100%]";
    //First row
    let tableLine = document.createElement("tr");
    const tab = "w-[25%] text-[20px] text-left bg-white";

    let tableCell = document.createElement("td");
    tableCell.className = tab + " bg-teal-400";
    tableCell.innerText = "Private phonenumber";
    tableLine.appendChild(tableCell);  

    tableCell = document.createElement("td");
    tableCell.className = tab + " ";
    tableCell.innerText = tableData.privatePhonenumber;
    tableLine.appendChild(tableCell);  
    
    tableCell = document.createElement("td");
    tableCell.className = tab + " bg-teal-400";
    tableCell.innerText = "Credit raiting";
    tableLine.appendChild(tableCell);  

    tableCell = document.createElement("td");
    tableCell.className = tab + " ";
    tableCell.innerText = tableData.creditRaiting;
    tableLine.appendChild(tableCell);
      
    subTable.appendChild(tableLine);
    //Second row
    tableLine = document.createElement("tr");

    tableCell = document.createElement("td");
    tableCell.className = tab + " bg-teal-400";
    tableCell.innerText = "Company phonenumber";
    tableLine.appendChild(tableCell);  

    tableCell = document.createElement("td");
    tableCell.className = tab + " ";
    tableCell.innerText = tableData.companyPhonenumber;
    tableLine.appendChild(tableCell);  
    
    tableCell = document.createElement("td");
    tableCell.className = tab + " bg-teal-400";
    tableCell.innerText = "Debt";
    tableLine.appendChild(tableCell);  

    tableCell = document.createElement("td");
    tableCell.className = tab + " ";
    tableCell.innerText = tableData.debt;
    tableLine.appendChild(tableCell);
      
    subTable.appendChild(tableLine);
    //Trith row
    tableLine = document.createElement("tr");

    tableCell = document.createElement("td");
    tableCell.className = tab + " bg-teal-400";
    tableCell.innerText = "Regular client";
    tableLine.appendChild(tableCell);  

    tableCell = document.createElement("td");
    tableCell.className = tab + " ";
    tableCell.innerText = tableData.regularClient;
    tableLine.appendChild(tableCell);  
    
    tableCell = document.createElement("td");
    tableCell.className = tab + " bg-teal-400";
    tableCell.innerText = "Creditcard";
    tableLine.appendChild(tableCell);  

    tableCell = document.createElement("td");
    tableCell.className = tab + " ";
    tableCell.innerText = tableData.creditCard;
    tableLine.appendChild(tableCell);
      
    subTable.appendChild(tableLine);
    //Fourth row
    tableLine = document.createElement("tr");

    tableCell = document.createElement("td");
    tableCell.className = tab + " bg-teal-400";
    tableCell.innerText = "VIP";
    tableLine.appendChild(tableCell);  

    tableCell = document.createElement("td");
    tableCell.className = tab + " ";
    tableCell.innerText = tableData.VIP;
    tableLine.appendChild(tableCell);  
    
    tableCell = document.createElement("td");
    tableCell.className = tab + " bg-teal-400";
    tableCell.innerText = "Bill";
    tableLine.appendChild(tableCell);  

    tableCell = document.createElement("td");
    tableCell.className = tab + " ";
    tableCell.innerText = tableData.bill;
    tableLine.appendChild(tableCell);
      
    subTable.appendChild(tableLine);
    //Fifth row
    tableLine = document.createElement("tr");

    tableCell = document.createElement("td");
    tableCell.className = tab + " bg-teal-400";
    tableCell.innerText = "Billing adress";
    tableLine.appendChild(tableCell);  

    tableCell = document.createElement("td");
    tableCell.className = tab + " ";
    tableCell.innerText = tableData.billingAdress;
    tableLine.appendChild(tableCell);  
    
    tableCell = document.createElement("td");
    tableCell.className = tab + " bg-teal-400";
    tableCell.innerText = "Prepayment";
    tableLine.appendChild(tableCell);  

    tableCell = document.createElement("td");
    tableCell.className = tab + " ";
    tableCell.innerText = tableData.prepayment;
    tableLine.appendChild(tableCell);
      
    subTable.appendChild(tableLine);

    return subTable;
}