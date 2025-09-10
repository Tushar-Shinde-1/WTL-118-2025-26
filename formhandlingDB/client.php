<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">


    <title>Document</title>
</head>
<body>
<div class="buttons">
    <div>
        <button onclick="showSection('insert')">Insert</button>
        <button onclick="showSection('display')">Display</button>
        <button onclick="showSection('delete')">Delete</button>
        <button onclick="showSection('update')">Update</button>
        </div>
</div>

<div class="main-content">

    <!-- Frontpage -->
    <div id="frontpage">
        <h1>Student Marks Information</h1>
        <p>Fill the student details in the form  with student name and current CGPA  </p>
    </div>

    <!-- Insert Section -->
    <div class="form-section form" id="insert-section">
        <h1>Fill the details</h1>
        <form>
            <div>
                <label for="name">Enter your Name</label>
                <input type="text" id="name" name="name">
            </div>
            <div>
                <label for="cgpa">Enter your CGPA</label>
                <input type="text" id="cgpa" name="cgpa">
            </div>
            <div>
                <button type="button" onclick="senddata()">Submit Details</button>
            </div>
        </form>
    </div>

    <!-- Display/Delete/Update Section -->
    <div class="form-section form " id="table-section">
        <h2>Student details</h2>
        <table border="1" id="table">
            <thead>
                <tr id="tr"></tr>
            </thead>
            <tbody id="tbody"></tbody>
        </table>
    </div>

</div>
<script>

function showSection(section) {
    // Hide all
    document.getElementById("frontpage").style.display = "none";
    document.getElementById("insert-section").style.display = "none";
    document.getElementById("table-section").style.display = "none";

    if (section === "insert") {
        document.getElementById("insert-section").style.display = "block";
    } else {
        document.getElementById("table-section").style.display = "block";
        if (section === "display") display();
        else if (section === "delete") displayWithDelete();
        else if (section === "update") displayWithUpdate();
    }
}

// ✅ At page load: show only frontpage
window.onload = () => {
    document.getElementById("frontpage").style.display = "block";
    document.getElementById("insert-section").style.display = "none";
    document.getElementById("table-section").style.display = "none";
};
const obj = {};

// Insert data
async function senddata() {
    obj.name = document.getElementById("name").value;
    obj.cgpa = document.getElementById("cgpa").value;

    if(obj.name==="")
{
    alert("fill all details");
    return;
}
const cgpavalidation=parseFloat(obj.cgpa);
if(isNaN(cgpavalidation))
{
    alert("CGPA must be a number");
    return;
}
if(cgpavalidation<0||cgpavalidation>10)
{
    alert("CGPA must be between 0 and 10.");
    return;  
}

    try {
        const response = await fetch("server.php", {
            method: "POST",
            headers: { 'Content-type': "application/json" },
            body: JSON.stringify(obj)
        });

        const result = await response.text();

        if(result) {
            alert("Data inserted successfully");
        } else {
            alert("Problem inserting data");
        }

    } catch (error) {
        console.log(error.message);
    }
}

// Display table without Delete/Update buttons
async function display() {
    try {
        const response = await fetch("display.php", { method: "GET" });
        const jsondata = await response.json();
        console.log(jsondata);

        if (!jsondata || jsondata.length === 0) {
    alert("No data found");
    return; // exit the function
}


        let tbody = document.getElementById("tbody");
        let tr = document.getElementById("tr");
        tr.innerHTML = "";
        tbody.innerHTML = "";

        const keys = Object.keys(jsondata[0]);
        keys.forEach((item) => {
            let th = document.createElement("th");
            th.textContent = item;
            tr.appendChild(th);
        });

        jsondata.forEach((item) => {
            let tr = document.createElement("tr");
            for (key in item) {
                let td = document.createElement("td");
                td.textContent = item[key];
                tr.append(td);
            }
            tbody.append(tr);
        });

    } catch (error) {
        console.log(error.message);
    }
}

// Display table with Delete button
async function displayWithDelete() {
    try {
        const response = await fetch("display.php", { method: "GET" });
        const jsondata = await response.json();
      
        if(!jsondata||jsondata.length===0)
    {
        alert("no data found !");
        return;
    }
        let tbody = document.getElementById("tbody");
        let tr = document.getElementById("tr");
        tr.innerHTML = "";
        tbody.innerHTML = "";

        const keys = Object.keys(jsondata[0]);
        keys.forEach((item) => {
            let th = document.createElement("th");
            th.textContent = item;
            tr.appendChild(th);
        });
        let thDel = document.createElement("th");
        thDel.textContent = "Delete";
        tr.appendChild(thDel);

        jsondata.forEach((item) => {
            let tr = document.createElement("tr");
            for (key in item) {
                let td = document.createElement("td");
                td.textContent = item[key];
                tr.append(td);
            }
            let tdd = document.createElement("td");
            let del = document.createElement("button");
            del.textContent = "Delete";
            del.style.backgroundColor="red";
            del.addEventListener("click", async () => {

                const confirmDelete = confirm("Are you sure you want to delete this record?");
    
    if (!confirmDelete) {
        return; // if user clicks Cancel, do nothing
    }
                
                let delresponse = await fetch("delete.php", {
                    method: "POST",
                    headers: { 'Content-type': 'application/json' },
                    body: JSON.stringify({ id: item.no })
                });
                console.log(await delresponse.text());
                tr.remove();
            });
            tdd.append(del);
            tr.appendChild(tdd);
            tbody.append(tr);
        });

    } catch (error) {
        console.log(error.message);
    }
}

// Display table with Update button
async function displayWithUpdate() {
    try {
        const response = await fetch("display.php", { method: "GET" });
        const jsondata = await response.json();

        if(!jsondata||jsondata.length===0)
    {
        alert("data not found");
    }

        let tbody = document.getElementById("tbody");
        let tr = document.getElementById("tr");
        tr.innerHTML = "";
        tbody.innerHTML = "";

        const keys = Object.keys(jsondata[0]);
        keys.forEach((item) => {
            let th = document.createElement("th");
            th.textContent = item;
            tr.appendChild(th);
        });
        let thUpdate = document.createElement("th");
        thUpdate.textContent = "Update";
        tr.appendChild(thUpdate);

        jsondata.forEach((item) => {
            let tr = document.createElement("tr");
            for (key in item) {
                let td = document.createElement("td");
                td.textContent = item[key];
                tr.append(td);
            }
            let tdu = document.createElement("td");
            let update = document.createElement("button");
            update.textContent = "Update";
            update.addEventListener("click", async () => {
    // Prompt for new values
    const newName = prompt("Enter new name:", item.name);
    if (newName === null || newName.trim() === "") {
        alert("Name cannot be empty");
        return;
    }

    const newCgpa = prompt("Enter new CGPA:", item.marks);
    const cgpaNum = parseFloat(newCgpa);
    if (isNaN(cgpaNum) || cgpaNum < 0 || cgpaNum > 10) {
        alert("CGPA must be a number between 0 and 10");
        return;
    }

    // Send updated data to server
    try {
        const response = await fetch("update.php", {
            method: "POST",
            headers: { 'Content-type': 'application/json' },
            body: JSON.stringify({ id: item.no, name: newName.trim(), cgpa: cgpaNum })
        });

        const result = await response.json();
        if (result.status === "success") {
            alert("Data updated successfully");
            displayWithUpdate(); // refresh table
        } else {
            alert(result.message);
        }
    } catch (error) {
        console.log(error.message);
    }
});

            // Optional: add update functionality here
            tdu.append(update);
            tr.appendChild(tdu);
            tbody.append(tr);





        });

    } catch (error) {
        console.log(error.message);
    }
}
</script>

</body>
</html>
