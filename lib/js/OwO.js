(() => {
    class OwO {
        constructor(option) {
            const defaultOption = {
                logo: 'OwO表情',
                container: document.getElementsByClassName('OwO')[0],
                target: document.getElementsByTagName('textarea')[0],
                position: 'down',
                style: 'width: 400px;',
                maxHeight: '250px',
                api: 'https://api.anotherhome.net/OwO/OwO.json'
            };
            for (let defaultKey in defaultOption) {
                if (defaultOption.hasOwnProperty(defaultKey) && !option.hasOwnProperty(defaultKey)) {
                    option[defaultKey] = defaultOption[defaultKey];
                }
            }
            this.container = option.container;
            this.target = option.target;
            if (option.position === 'up') {
                this.container.classList.add('OwO-up');
            }

            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = () => {
                if (xhr.readyState === 4) {
                    if (xhr.status >= 200 && xhr.status < 300 || xhr.status === 304) {
                        this.odata = JSON.parse(xhr.responseText);
                        this.init(option);
                    }
                    else {
                        console.log('OwO data request was unsuccessful: ' + xhr.status);
                    }
                }
            };
            xhr.open('get', option.api, true);
            xhr.send(null);
        }

        init(option) {
            this.area = option.target;
            this.packages = Object.keys(this.odata);

            // fill in HTML
            let html = `
            <div class="OwO-logo"><span>${option.logo}</span></div>
            <div class="OwO-body" style="${option.style}">`;

            for (let i = 0; i < this.packages.length; i++) {
                html += `
                <ul class="OwO-items OwO-items-${this.odata[this.packages[i]].type}" style="max-height: ${parseInt(option.maxHeight) - 53 + 'px'};">`;
                if (this.odata[this.packages[i]].type === 'smiles') {

                    let baseURL = this.odata[this.packages[i]].baseURL;
                    let suffix = this.odata[this.packages[i]].suffix;
                    let input = this.odata[this.packages[i]].input;
                    let imgClass = this.odata[this.packages[i]].imgClass;
                    let opackage = this.odata[this.packages[i]].container;

                    baseURL = baseURL.replace('{SMILES_EMOJI_PATH}', LocalConst.SMILES_EMOJI_PATH);

                    for (let i = 0; i < opackage.length; i++) {
                        let imageSrc = baseURL + opackage[i] + suffix;
                        let imageTag = `<img data-src="${imageSrc}" class="${imgClass}" title="${opackage[i]}">`;
                        let inputData = input.replace('{NAME}', opackage[i]);
                        if (input !== '{IMG_TAG}') {
                            inputData = `data-input="${inputData}"`;
                        } else {
                            inputData = '';
                        }
                        html += `
                    <li class="OwO-item" title="${opackage[i]}" ${inputData}>${imageTag}</li>`;
                    }

                } else {
                    let opackage = this.odata[this.packages[i]].container;
                    for (let i = 0; i < opackage.length; i++) {

                        html += `
                    <li class="OwO-item" title="${opackage[i].text}">${opackage[i].icon}</li>`;

                    }
                }

                html += `
                </ul>`;
            }

            html += `
                <div class="OwO-bar">
                    <ul class="OwO-packages">`;

            for (let i = 0; i < this.packages.length; i++) {

                html += `
                        <li><span>${this.packages[i]}</span></li>`

            }

            html += `
                    </ul>
                </div>
            </div>
            `;
            this.container.innerHTML = html;

            // bind event
            this.logo = this.container.getElementsByClassName('OwO-logo')[0];
            this.logo.addEventListener('click', (e) => {
                this.toggle(e);
            });

            this.container.getElementsByClassName('OwO-body')[0].addEventListener('click', (e)=> {
                let target = null;
                if (e.target.classList.contains('OwO-item')) {
                    target = e.target;
                }
                else if (e.target.parentNode.classList.contains('OwO-item')) {
                    target = e.target.parentNode;
                }
                if (target) {
                    const cursorPos = this.area.selectionEnd;
                    let areaValue = this.area.value;
                    let inputValue = target.innerHTML;
                    if (target.dataset.hasOwnProperty('input')) {
                        inputValue = target.dataset.input;
                    }
                    this.area.value = areaValue.slice(0, cursorPos) + inputValue + areaValue.slice(cursorPos);
                    this.moveCaretRange(cursorPos + inputValue.length);
                    this.area.focus();
                    this.toggle(e);
                }
            });

            this.packagesEle = this.container.getElementsByClassName('OwO-packages')[0];
            for (let i = 0; i < this.packagesEle.children.length; i++) {
                ((index) =>{
                    this.packagesEle.children[i].addEventListener('click', (e) => {
                        this.tab(index, e);
                    });
                })(i);
            }

            this.tab(0);
        }

        moveCaretRange(newCursorPos) {
            if (this.area.setSelectionRange) {
                this.area.focus();
                this.area.setSelectionRange(newCursorPos, newCursorPos);
            }
            else if (this.area.createTextRange) {
                let range = this.area.createTextRange();
                range.collapse(true);
                range.moveEnd('character', newCursorPos);
                range.moveStart('character', newCursorPos);
                range.select();
            }
        }

        toggle(e) {
            let body = document.getElementById('body');
            if (!body) {
                body = document.getElementsByClassName('body')[0];
            }

            let closeOwo = (e) => {
                this.container.classList.remove('OwO-open');
                document.getElementsByTagName('body')[0].classList.remove('OwO-open');
                if (body) {
                    body.removeEventListener('click', closeOwo);
                }
                e.stopPropagation();
            };

            if (this.container.classList.contains('OwO-open')) {
                this.container.classList.remove('OwO-open');
                document.getElementsByTagName('body')[0].classList.remove('OwO-open');
            }
            else {
                this.container.classList.add('OwO-open');
                document.getElementsByTagName('body')[0].classList.add('OwO-open');
                if (body) {
                    body.removeEventListener('click', closeOwo);
                    body.addEventListener('click', closeOwo);
                }
                this.loadImageForCurrentTab();
                e.stopPropagation();
            }
        }

        tab(index, e) {
            const itemsShow = this.container.getElementsByClassName('OwO-items-show')[0];
            if (itemsShow) {
                itemsShow.classList.remove('OwO-items-show');
            }
            this.container.getElementsByClassName('OwO-items')[index].classList.add('OwO-items-show');

            this.loadImageForCurrentTab();

            const packageActive = this.container.getElementsByClassName('OwO-package-active')[0];
            if (packageActive) {
                packageActive.classList.remove('OwO-package-active');
            }
            this.packagesEle.getElementsByTagName('li')[index].classList.add('OwO-package-active');
            if (typeof e != 'undefined') {
                e.stopPropagation();
            }
        }

        loadImageForCurrentTab() {
            if (this.container.classList.contains("OwO-open")) {
                let list = this.container.querySelectorAll(".OwO-items.OwO-items-show>li img");
                [].forEach.call(list, function (img) {
                    let src = img.dataset.src;
                    if (src) {
                        img.src = src;
                        img.removeAttribute("data-src");
                    }
                });
            }
        }
    }
    if (typeof module !== 'undefined' && typeof module.exports !== 'undefined') {
        module.exports = OwO;
    }
    else {
        window.OwO = OwO;
    }
})();