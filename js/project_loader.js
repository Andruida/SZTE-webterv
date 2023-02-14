
$(document).ready(() => {
    const params = new Proxy(new URLSearchParams(window.location.search), {
        get: (searchParams, prop) => searchParams.get(prop),
    });

    fetch("data.json").then((res) => res.json()).then((data) => {
        console.log(data)
        document.title = document.title + " - " + params.projectName
        $("span#projectName").text(params.projectName)
        const pData = data[params.projectName];
        if (!pData) return

        $("img#projectImage").attr("src", pData.img)
        $("img#projectImage").attr("alt", params.projectName)
        var originalAudio = $("audio#song")
        var newAudio = originalAudio.clone()
        newAudio.find("source").attr("src", pData.sound)
        originalAudio.after(newAudio)
        originalAudio.remove()

        $("p#description").html(pData.html)
        
    })
    
})