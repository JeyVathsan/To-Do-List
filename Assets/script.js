function openModal(taskId, taskValue) {
    document.getElementById("taskId").value = taskId;
    document.getElementById("taskValue").value = taskValue;
    document.getElementById("updateModal").style.display = "block";
}

function closeModal() {
    document.getElementById("updateModal").style.display = "none";
}