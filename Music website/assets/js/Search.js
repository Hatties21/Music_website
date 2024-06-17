function searchMusic() {
    var input, filter, ul, li, a, i, txtValue, found;
    input = document.getElementById('searchInput');
    filter = input.value.toUpperCase();
    ul = document.getElementById("musicList");
    li = ul.getElementsByTagName('li');
    found = false;
    for (i = 0; i < li.length; i++) {
      a = li[i].getElementsByTagName("a")[0];
      txtValue = a.textContent || a.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        li[i].style.display = "";
        found = true;
      } else {
        li[i].style.display = "none";
      }
    }
    var noResult = document.getElementById('noResult');
    if (!found) {
      if (!noResult) {
        noResult = document.createElement('li');
        noResult.id = 'noResult';
        noResult.innerText = 'Không tìm thấy kết quả';
        ul.appendChild(noResult);
      }
      noResult.style.display = "";
    } else if (noResult) {
      noResult.style.display = "none";
    }
  }