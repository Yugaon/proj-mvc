Den här pseudokoden är för mitt 21 spel med en tärning. Inte controllers utan bara den koden helt själv.

Innan spelet startas, lägg till några värden i sessionen för att använda i klass metoderna, för att spara totala värdet, historik etc.

Funktionen roll (
    Anropa request och session så man kan använda de.
    Rulla tärningen och få ett värde mellan 1 och max antal sidor, spara i sessionen.

    Kolla om värdet är lika med 21.
    {
      Spelaren vinner, spara detta i sessionen, hantera bet om det finns ett bet.
      Kalla funktionen reset() så att man kan spela spelet igen.
    }

    Kolla om värdet är högre än 21.
    {
      Datorn vinner, spara detta i sessionen, hantera bet om det finns ett bet.
      Kalla funktionen reset() så att man kan spela spelet igen.
    }
    return last roll.
  )

Funktionen getLastRoll (
    Returnar det senaste roll
  )

Funktionen getTotal  (
    Tar in request och returnerar total ifrån sessionen
  )

Funktionen Reset (
    Reset mer temporära variablerna i sessionerna.
  )

Funktionen ResetScore (
    Reset alla variabler i spelet variablerna i sessionerna.
  )

Funktionen Message (
    Returnar klass attributen message som ändras när man vinner/förlorar
  )

Funktionen Historik (
    Returnar historiken ifrån sessionen som en array. Arrayen fylls på när man vinner eller förlorar.
  )

Funktionen computer (
    Kallas på när man klickar på stop knappen, nu är det datorns tur att spela.
    Lokal variabel som sparar totalen för all rolls.

    En while loop som körs medans värdet är mindre än 21 eller värdet är lika med det som spelaren rullat (

      En random roll mellan 1 och antal sidor, sparas i variablen för datorns total.
      If satster som kollar samma saker som i roll() för att se om personen förlorar eller vinner.
      Lägger till i historiken osv. beroende på vad som sker.
      )




  )
