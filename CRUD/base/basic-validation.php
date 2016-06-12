<?php
/**
 * Created by PhpStorm.
 * User: wexnox
 * Date: 08/06/2016
 * Time: 17:11
 */
function validerflyplasskode($flyplasskode)
{
    $lovligflyplasskode=true;

    // hvis den er tom
    if (!$flyplasskode)
    {
        $lovligflyplasskode=false;
        print ("Klassekode må fylles ut");
    }
    // hvis det er mindre en tre bokstaver
    else if (strlen($flyplasskode) < 3)
    {
        $lovligflyplasskode=false;
        print ("flyplasskode må inneholde minst 3 tegn");

    }
    else if (ctype_alpha(substr($flyplasskode, -1)))
    {
        $lovligflyplasskode=false;
        print ("Må ha tall på slutten");
    }
    else if (ctype_lower(substr($flyplasskode, 0, -1)))
    {
        $lovligflyplasskode=false;
        print ("flyplasskode må inneholde kun store bokstaver og 1 tall på slutten");
    }
    else {
        for ($teller = 1; $teller <= 3; $teller++) {
            $tegn[$teller] = substr($flyplasskode, $teller - 1, 1);
        }
        if ($tegn[1] < "A" || $tegn[1] > "Z" || $tegn[2] < "A" || $tegn[2] > "Z" || $tegn[3] < "A" || $tegn[3] > "Z") {
            $lovligflyplasskode = false;
        }
    }
    return $lovligflyplasskode;
}
function validerflymodel($flymodel)
{

}
function validerflymodelnavn($flymodelnavn)
{

}
function validerFly($fly)
{
    $lovligfly=true;
}
// TODO: Antallseter ingen manuel input, men antall seter på fly må begrenses til max antallseter i flymodellen (min-max, hvor max er modellen ikke flyet, flyet kan ikke ha fler plasser enn modellen)
// TODO: Som med antallseter rekkevidde kan man ikke inputte manuelt så ingen validering, men må ikke overskride modellen
// TODO: men tidspunkter må valideres så flyet ikke lander før det har tatt av fra flyplassen
?>