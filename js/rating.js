$(document).ready(() => {
    $("input[name=\"rating\"]").on("change", (e) => {
        const rating = e.target.value
        const projectName = window.location.search.split("=")[1]
        $.post("backend/rating.php", {
            projectName: projectName,
            rating: rating
        })
    })
})