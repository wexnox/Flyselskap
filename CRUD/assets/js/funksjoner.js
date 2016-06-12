/**
 * Created by wexnox on 23.02.2016.
 */
function bekreft ()
{
    return confirm("Er du sikker?");
}

function validerRegistrerklasse() {
    "use strict";
    var klassekode = document.getElementById("klassekode").value;
    var klassenavn = document.getElementById("klassenavn").value;
    var feilmelding = "";
    if (!klassekode)  // Er klassekode er ikke korrekt fylt ut?
    {
        feilmelding = "klassekode er ikke korrekt fylt ut <br />";
    }
    if (!klassenavn)  // Er klassenavn er ikke fylt ut?
    {
        feilmelding = feilmelding + "klassenavn er ikke fylt ut <br />";
    }
    if (klassekode && klassenavn)  // Er alle felt er korrekt fylt ut
    {
        return true;
    }
    else
    {
        document.getElementById("melding").style.color="red";
        document.getElementById("melding").innerHTML=feilmelding;
        return false;
    }
}

function validerRegistrerStudent() {
    "use strict";
    var brukernavn = document.getElementById("brukernavn").value;
    var etternavn = document.getElementById("etternavn").value;
    var fornavn = document.getElementById("fornavn").value;
    var klassekode = document.getElementById("klassekode").value;

    var feilmelding = "";

    if (!brukernavn) // er brukernavn fylt ut?
    {
        feilmelding ="brukernavn er ikke korrekt fylt ut <br />";
    }
    if (!etternavn) // Er etternavnet korrekt fylt ut?
    {
        feilmelding ="Etternavn er ikke korrekt fylt ut <br />";
    }
    if (!fornavn) // Er fornavnet fylt ut?
    {
        feilmelding ="Fornavn er ikke korrekt fylt ut <br />";
    }
    if (!klassekode)  // Er klassekode er ikke korrekt fylt ut?
    {
        feilmelding = "klassekode er ikke korrekt fylt ut <br />";
    }
    if (brukernavn && etternavn && fornavn && klassekode)  // Er alle felt er korrekt fylt ut
    {
        return true;
    }
    else
    {       // farging av feilmelding
        document.getElementById("melding").style.color="red";
        document.getElementById("melding").innerHTML=feilmelding;
        return false;
    }
}