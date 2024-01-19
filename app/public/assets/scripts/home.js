const url = window.location.href
const route = url.lastIndexOf('/');
const result = '__visit__'+url.substring(route + 1);
if (localStorage.getItem(result) === null) {
    localStorage.setItem(result, 1)
} else {
    localStorage.setItem(result, String(Number(localStorage.getItem(result))+1))
}
let entries = 'Vizite -> '
for (let i = 0; i < localStorage.length; i++){
    if (localStorage.key(i).includes('__visit__')) {
        if (localStorage.key(i).replace('__visit__', '') === '') {
            entries += 'landing: ' + localStorage.getItem(localStorage.key(i)) + '; '
        } else {
            entries += localStorage.key(i).replace('__visit__', '') + ': ' + localStorage.getItem(localStorage.key(i)) + '; '
        }
    }
}
if (localStorage.getItem('source') === null) {
    entries += 'Contact de pe pagina "landing"'
} else {
    entries += 'Contact de pe pagina "'+localStorage.getItem('source')+'".'
}
window.onload = function WindowLoad(event) {
    if (document.getElementById('entries') !== null) {
        document.getElementById('entries').value = entries
    }
}
function goToSection(sectionId) {
    if (document.getElementById(sectionId) !== null) {
        document.getElementById(sectionId).scrollIntoView({behavior: 'smooth', block: 'start'})
    } else {
        redirectToRoute('/#' + sectionId)
    }
}
function redirectToRoute(route) {
    window.location.href = route
}

function openInNewTab(url) {
    window.open(url, '_blank')
}

function markCurrentPageAsSource() {
    localStorage.setItem('source', url.substring(route + 1))
    redirectToRoute('/#contact')
}