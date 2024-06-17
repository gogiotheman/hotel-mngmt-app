const services = [];

function addService() {
    var selectElement = document.getElementById("Service");
    var selectedOption = selectElement.options[selectElement.selectedIndex].text;

    services.push(selectedOption);

    // Display the selected option in the options list
    var optionsListElement = document.getElementById("servicesList");
    var optionDiv = document.createElement("div");
    optionDiv.textContent = selectedOption;
    optionDiv.classList.add("btn", "serviceoption");

    // Add a button to delete the option
    var deleteButton = document.createElement("i");
    deleteButton.classList.add("fa-solid", "fa-circle-xmark", "xbutton")
    deleteButton.onclick = function() {
        optionsListElement.removeChild(optionDiv);
        const index = services.indexOf(optionDiv.textContent);
        services.splice(index, 1);
    };

    optionDiv.appendChild(deleteButton);
    optionsListElement.appendChild(optionDiv);

    // Clear the selected option from the dropdown
    selectElement.selectedIndex = "Services to add";
}

function changeRoomSelectionColor(){
    var selectedRoom = document.getElementById("RoomType");
    if(selectedRoom.value){
        selectedRoom.className = 'selectinput roomselected';
    }
    else{
        selectedRoom.className = 'selectinput';
    }
}

function getReservationDetails(){
    var RoomType = document.getElementById("RoomType").value;
    var cin = document.getElementById("cin").value;
    var cout = document.getElementById("cout").value;
    $.ajax({
        type: 'POST',
        url: 'home.php',
        data: { serviceArray : JSON.stringify(services),
                roomType : RoomType,
                checkIn : cin,
                checkOut : cout },
        cache: false,
        success: function(response){
            var tempDiv = document.createElement('div');
            tempDiv.innerHTML = response;
            
            var phpResponseContent = tempDiv.querySelector('#phpResponse').textContent;
            var jsonResponse = JSON.parse(phpResponseContent);

            console.log(response);
            swal({
                icon: jsonResponse.status,
                title: jsonResponse.message,
            });
        },
        error: function(error){
            console.error(error);
        }
    })

}

$(document).ready(function () {
    $('#guestdetailpanelform').submit(function(e){
        e.preventDefault();
        getReservationDetails();
    })
})

