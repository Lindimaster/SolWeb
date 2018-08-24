$(document).ready(() =>
{
    $("div .php").append("<p>").attr("id", "log");
    $.ajax(
        {
            url: "../scripts/server.php?userid=" + userid,
            type: "GET",
            encoding:"UTF-8",
            success: function (result)
            {
                var obj = jQuery.parseJSON(result);
                fillTables(obj);
            }
        });
});

function fillTables(data)
{
    var table = $("#pvSystemTable");
    var tr = $("<tr>");
    var td = $("<td>");

    for(let i = 0;i < data.length;i ++)
    {

      td.html(data[i]["pvname"]);
      tr.append(td);

      td = $("<td>");
      td.html(data[i]["size"]);
      tr.append(td);

      td = $("<td>");
      td.html(data[i]["alignment"]);
      tr.append(td);

      td = $("<td>");
      td.html(data[i]["inclination"]);
      tr.append(td);

      td = $("<td>");
      td.html(data[i]["description"]);
      tr.append(td);

      td = $("<td>");
      var location = data[i]["street"] + " " + data[i]["housenumber"] + ", " + data[i]["postalcode"] + " " + data[i]["cityname"];
      td.html(location);
      tr.append(td);

      td = $("<td>");

      if(data[i]["linksolarweb"] !== null && data[i]["linksolarweb"] !== "")
      {
        var a = $("<a>");
        a.attr("href", data[i]["linksolarweb"]);
        a.html("Öffnen");
        td.append(a);
      }
      tr.append(td);

      table.append(tr);
      tr = $("<tr>");
      td = $("<td>");
    }
}
