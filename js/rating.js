$(document).ready(() => {
    $("input[name=\"rating\"]").on("change", (e) => {
        const rating = e.target.value
        const projectId = window.location.search.split("=")[1]
        $.post("backend/rating.php", {
            projectId: projectId,
            rating: rating
        })
    })
})