Kanan-banan
===========

Här är koden+config filer på allt som kördes på FitPCn för Vässarös temporära vattenruschkana 2012

https://github.com/buffpojken/Kanan/
https://github.com/stampzilla/stampzilla/


##Historik

Till första Boomerang (2003) gjordes en hel hög med jippon för deltagarna, bland annat kanotbio och hoppborgar. Det talades redan då om att bygga en vattenrutschkana. Sedan dess har Fredrik med jämna mellanrum letat efter vattenrutschkanor på kända annons-siter på internet.

Den 16e Augusti 2011 Ringde Fredrik till David och meddelade att han hittat en begagnad kana till ett bra pris på blocket. David befann sig på WSJ arbetandes med site services. Vid fikabordet där David satt och tog emot samtalet satt också stora delar av de som varit inblandade i bygget.
##Transport, Planering & Projektering

Transporten av kanan löstes under hösten 2011, ett lastbilslass och någon släpvagn fylld med plastbitar och stålkonstruktion. Planering av bygget har pågått sedan dess.

Originalritningar från den ursprungliga platsen lokaliserades med hjälp av tillverkaren, därefter gjordes egna ritningar i både två och tre dimensioner. För 3d-ritningens skull mättes terrängen in och sedan dess har det klurats på konstruktion.
##Renoveringen

Den stora renoveringen av kanans plastskador skedde omkring midsommar där vi fick hjälp av Nisse som visade vägen för hur det skulle gå till.
Bygget

Bygget av kanan påbörjades 21 Juli, och det första provåket gjordes 29 Juli. Arbetslaget har varierat mellan 4 och 8 personer, totalt har ~1000 arbetstimmar lagts på bygget.
##Elektronik
Kanan styrs helt elektroniskt via ett stort antal komponenter som reglerar allt från vattenpump och ljud till stoppljus och målkamera. Samtliga kontroller är tillgängliga från Funk-teamets mobiltelefoner så hela vattenruschkanan kan styras från en smartphone. Komponenterna pratar med varandra över ett UDP-baserat protokoll och kommunicerar via både trådlöst internet, nätverkskabel och hemmabyggda lösningar.

##Pumpen

Pumpen styrs via en PLC och ett php-bibliotek kallat Beckhoff (http://github.com/stampzilla), som i sin tur kommunicerar med en demon skriven i Ruby och Eventmachine som exponerar ett API. API:t anropas i sin tur av en mobil hemsida via JSONP.
##Stoppljus

Stoppljuset styrs på två olika sätt, antingen i s.k. automatläge där PLC:en själv administrerar start/stopp genom sensorer i början och slutet på banan eller i kommandoläge där PLC:en och Ruby-demonen samarbetar och gemensamt hanterar läge på stoppljuset. Stoppljust kan även styras på manuell override genom Funk-teamets mobiltelefoner.
##Musik/Ljudeffekter
Kanan har ett ljudsystem som kan kontrolleras från mobiltelefonerna för att dels spela ljudeffekter såsom applåder eller gapskratt, dels för att spela t.ex. webbradio eller mp3-bibliotek. Ljudeffekterna kontrolleras med en annan Ruby-demon som lyssnar på samma UDP-protokoll som resten av systemet. Detta körs på en FitPC inkopplad till PA-anläggningen.

Kanan
=====

Här är koden+config filer på allt som kördes på webservern för Vässarös temporära vattenruschkana 2012

https://github.com/buffpojken/Kanan/
https://github.com/stampzilla/stampzilla/



##Historik

Till första Boomerang (2003) gjordes en hel hög med jippon för deltagarna, bland annat kanotbio och hoppborgar. Det talades redan då om att bygga en vattenrutschkana. Sedan dess har Fredrik med jämna mellanrum letat efter vattenrutschkanor på kända annons-siter på internet.

Den 16e Augusti 2011 Ringde Fredrik till David och meddelade att han hittat en begagnad kana till ett bra pris på blocket. David befann sig på WSJ arbetandes med site services. Vid fikabordet där David satt och tog emot samtalet satt också stora delar av de som varit inblandade i bygget.
##Transport, Planering & Projektering

Transporten av kanan löstes under hösten 2011, ett lastbilslass och någon släpvagn fylld med plastbitar och stålkonstruktion. Planering av bygget har pågått sedan dess.

Originalritningar från den ursprungliga platsen lokaliserades med hjälp av tillverkaren, därefter gjordes egna ritningar i både två och tre dimensioner. För 3d-ritningens skull mättes terrängen in och sedan dess har det klurats på konstruktion.
##Renoveringen

Den stora renoveringen av kanans plastskador skedde omkring midsommar där vi fick hjälp av Nisse som visade vägen för hur det skulle gå till.
Bygget

Bygget av kanan påbörjades 21 Juli, och det första provåket gjordes 29 Juli. Arbetslaget har varierat mellan 4 och 8 personer, totalt har ~1000 arbetstimmar lagts på bygget.
##Elektronik
Kanan styrs helt elektroniskt via ett stort antal komponenter som reglerar allt från vattenpump och ljud till stoppljus och målkamera. Samtliga kontroller är tillgängliga från Funk-teamets mobiltelefoner så hela vattenruschkanan kan styras från en smartphone. Komponenterna pratar med varandra över ett UDP-baserat protokoll och kommunicerar via både trådlöst internet, nätverkskabel och hemmabyggda lösningar.

##Pumpen

Pumpen styrs via en PLC och ett php-bibliotek kallat Beckhoff (http://github.com/stampzilla), som i sin tur kommunicerar med en demon skriven i Ruby och Eventmachine som exponerar ett API. API:t anropas i sin tur av en mobil hemsida via JSONP.
##Stoppljus

Stoppljuset styrs på två olika sätt, antingen i s.k. automatläge där PLC:en själv administrerar start/stopp genom sensorer i början och slutet på banan eller i kommandoläge där PLC:en och Ruby-demonen samarbetar och gemensamt hanterar läge på stoppljuset. Stoppljust kan även styras på manuell override genom Funk-teamets mobiltelefoner.
##Musik/Ljudeffekter
Kanan har ett ljudsystem som kan kontrolleras från mobiltelefonerna för att dels spela ljudeffekter såsom applåder eller gapskratt, dels för att spela t.ex. webbradio eller mp3-bibliotek. Ljudeffekterna kontrolleras med en annan Ruby-demon som lyssnar på samma UDP-protokoll som resten av systemet. Detta körs på en FitPC inkopplad till PA-anläggningen.


