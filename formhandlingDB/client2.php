// DO NOT USE THIS FILE FOR THE RESULT 
//IT IS ONLY FOR SIMPLE LOGICAL UNDERSTANDING IN SIMPE WAY


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    


<div>
    <h1>Fill the details</h1>

    <form >
        <label for="name">Enter your Name </label>
        <input type="text" id="name" name="name">
        <label for="cgpa">Enter your CGPA</label>
        <input type="text" id="cgpa" name="cgpa">
        <button type="button" onclick="senddata()">Submit Details</button>
    </form>
</div>



<div>
    <h2>Student details</h2>
    <table border="1" id="table">
        <tr id="tr"></tr>
        <tbody id="tbody"></tbody>
    </table>
</div>
<script>
    const obj  ={};

       async function senddata(){
    obj.name=document.getElementById("name").value;
    obj.cgpa=document.getElementById("cgpa").value;


    console.log(obj.name);
    console.log(obj.cgpa);
       

try{

       const response= await fetch("server.php",
      { method:"POST",
       headers:{
        'Content-type':"application/json"
       },
       body :JSON.stringify(obj)
    });

if(!response.ok)
{
throw new Error (`problem in server ${response.status}`);
}
 console.log(response);
 const jsondata= await response.json();
 console.log(jsondata)



 let table=document.getElementById("table");
 let tbody=document.getElementById("tbody");
 let tr=document.getElementById("tr");

 
 const keys=Object.keys(jsondata[0]);
 console.log(keys)


 keys.forEach((item)=>
{   
    let th = document.createElement("th");  
    th.textContent = item;                   
    tr.appendChild(th);  
});
   let thd = document.createElement("th");  
    thd.textContent = "Delete";                   
    tr.appendChild(thd);  

    let th = document.createElement("th");  
    th.textContent = "Update";                   
    tr.appendChild(th);  

 jsondata.forEach((item)=>{
    let tr=document.createElement("tr");
    console.log(item);
for (key in item)
{
    let td=document.createElement("td");
    td.textContent=item[key];
    tr.append(td);

}
let tdd = document.createElement("th");  
let del=document.createElement("button");
del.textContent="Delete";

del.addEventListener("click",async ()=>{
    console.log(item.no);
    let delresponse= await fetch("delete.php",{
        method:"post",
        headers:{
            'Content-type':'application/json'
        },
        body:JSON.stringify({id:item.no})
    })
console.log(await delresponse.text());
    tr.remove();
    
    //id of row should go to backend
});
tdd.append(del); 
                   
    tr.appendChild(tdd);  
    let td = document.createElement("th");  
    let up=document.createElement("button");   
    up.textContent="Update";  
    td.append(up);            
    tr.appendChild(td); 
    tbody.append(tr);

 })
}
catch(error)
{
console.log(error.message);
}

    
}  



function display()
{
    
}
</script>
</body>

</html>
