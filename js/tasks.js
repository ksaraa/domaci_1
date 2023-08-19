$('input[type=radio][name=selected-status]').change(function () {
    $.ajax({
        url: 'api/tasks.php?status_id=' + this.value,
        method: 'GET',
        success: function (response) {
            const arr = JSON.parse(response)
            var table = $("#tasks-table");
            table.find("tr:not(:first)").remove();

            arr.forEach(entry => {
                var newRow = $("<tr>");
                newRow.append("<td>" + entry.taskId + "</td>");
                newRow.append("<td>" + entry.name + "</td>");
                newRow.append("<td>" + entry.status.status + "</td>");
                newRow.append("<td><a href='task.php?id=" + entry.taskId + "'>Edit</a></td>");
                table.append(newRow);
            });
        },
        error: function (xhr, status, error) {
            console.log(error);
        }
    });
});

$(document).on('submit', '#task-form', function (e) {
    e.preventDefault();
    console.log($(this).serialize());
    $.ajax({
        method: "POST",
        url: "api/tasks.php",
        data: $(this).serialize(),
        success: function (data) {
            if (data != '-1') {
                window.location.href = 'task.php?id='+data;
            } else {
                alert("ERROR");
            }
        }
    });
});