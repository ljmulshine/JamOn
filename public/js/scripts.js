/**
 * scripts.js
 *
 * Liam Mulshine and Spencer Hallyburton
 * Final Project
 *
 * Global JavaScript
 */
 
// check for common input errors in create and join group forms
function check()
{     
    if(document.getElementById("groups").value == '' || document.getElementById("groups").value == ' ' || /^[a-zA-Z0-9 ]+$/.test(document.getElementById("groups").value) == false)
    {
        alert("Invalid Group Name");
        return false; 
    }
    
}
//alerts the user once groups are updated
function update()
{
    alert("All of your groups now contain your current favorites!");

}

