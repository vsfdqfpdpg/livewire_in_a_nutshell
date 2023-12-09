window.livewire = () => {
    return {
        start() {
            let This = this;
            document.querySelectorAll("[wire\\:snapshot]").forEach(function (element) {
                element.__livewire = JSON.parse(element.getAttribute('wire:snapshot'));
                This.initClick(element)
            });
        },
        initClick(element) {
            let This = this;
            element.addEventListener("click", el => {
                if (!el.target.hasAttribute("wire:click")) return;
                let method = el.target.getAttribute("wire:click");
                This.sendRequest(element, {callMethod: method})
            });
        },
        sendRequest(el, payload) {
            let snapshot = el.__livewire;
            fetch("/livewire", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "text/html, application/xhtml+xml",
                },
                body: JSON.stringify({
                    snapshot,
                    ...payload,
                })
            }).then(response => response.json()).then(response => {
                let [html, snapshot] = response;
                el.innerHTML = html;
                el.__livewire = snapshot;
            });
        }
    }
}




