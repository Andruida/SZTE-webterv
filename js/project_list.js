$(document).ready(() => {
    fetch("data.json").then((res) => res.json()).then((data) => {
        const div = $("#list")
        div.empty()
        Object.keys(data).forEach((k) => {
            const pData = data[k];
            if (!pData) return;
            div.append(`
            <div data-project-name="${k}">
                <img src="${pData.img}" width="100" alt="">
                <h3>${k}</h3>
                <p>
                    ${pData.html}
                </p>
                <audio controls>
                    <source src="${pData.sound}" type="audio/mpeg">
                  A böngésződ sajnos nem támogatja csodás dalaim lejátszását :c
                  </audio>
            </div>
            `)
        })
        $("div[data-project-name]").click((e) => {
            console.log(e)
            if ($(e.delegateTarget).data("project-name") !== undefined)
                window.location = "/projekt.html?projectName="+encodeURI($(e.delegateTarget).data("project-name"))
        })
    })
})