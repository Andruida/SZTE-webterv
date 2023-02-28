$(document).ready(() => {
    $("div[data-project-id]").click((e) => {
        console.log(e)
        if ($(e.delegateTarget).data("project-id") !== undefined)
            window.location = "projekt.php?projectId="+encodeURI($(e.delegateTarget).data("project-id"))
    })
})