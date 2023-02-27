# SZTE-webterv

## 1. mérföldkő [✅]

- [x] *80+ pont elérve*

## 2. mérföldkő

### Általános szempontok (max: 25 pont) (elérve: 18)
#### Menü - 4 pont (elérve: 4)
- [x] A rendelkezésre álló menüpontok minden oldalon láthatóak, a navigáció közöttük megfelelően működik (0/1 pont)
- [x] A felhasználó mindig tudja, hogy melyik oldalon van éppen (pl. az aktuális menüpont
más dizájnnal jelenik meg) (0/1 pont)
- [x] A menü interaktív: a kurzor rávitelére változik a menüpont kinézete (0/1 pont)
- [x] A menü / oldal fejléc az oldal görgetésénél is látszik (0/1 pont)
#### Felhasználói élmény - 17 pont (elérve: 9)
- [x] Az elkészített weboldalak logikusan vannak felépítve, egyértelmű, hogy milyen műveleteket lehet csinálni, hogyan, egyértelműen jelezve van minden szükséges információ (0/1/3
pont)
- [x] Az oldalakon minden információ jól olvasható (pl. nem fekete háttéren sötét betűk), nem
lógnak egybe a szövegek vagy egyéb elemek, van elegendő hely hagyva az elemek között,
stb. (0/1/3 pont)
- [x] Az oldalon nincsenek hibák: nem jelennek meg warningok, notice-ok, vagy egyéb rosszul
beállított elemek (pl. img tag, érvénytelen képpel), minden ott lévő funkció működik (0/3
pont)
- [ ] Az űrlapok intuitívak, és a felhasználó számára jelezve van, hogy mi a követelmény az
adott input mezőre nézve (pl. a jelszó legalább 8 karakter), ezek nem az űrlap elküldése
után jutnak a felhasználó tudtára (0/3 pont)
- [ ] A megvalósított funkciók használata kényelmes (0/2/5 pont)
#### Technikai elemek - 9 pont (elérve: 5)
- [x] GET paraméterek megfelelő használata (0/2 pont)
- [ ] Objektumorientáltság megfelelő használata (0/2/4 pont)
- [x] Sütik értelmes módon való használata (0/3 pont)

### Megvalósított funkciók (max: 65 pont) (elérve: 23)
#### Regisztráció - 13 pont (elérve: 13)
- [x] Van működő regisztráció, a helyes regisztráció hatására az új felhasználó adatai eltárolódnak (0/2 pont)
- [x] Minden kötelezően kitöltendő űrlapmező kitöltése szerveroldalon is ellenőrizve van (0/2
pont)
- [x] Ha foglalt a felhasználónév (vagy e-mail cím), akkor nem regisztrálja be az új felhasználót
(0/2 pont)
- [x] A jelszót két alkalommal kell beírni, ezek azonossága vizsgálva van (0/2 pont)
- [x] Ha valamelyik mezőt rosszul (vagy nem) tölti ki a felhasználó, akkor a weboldal erre
figyelmezteti, pontos hibajelzéssel, az összes hibát jelezve (0/2 pont)
- [x] A felhasználók jelszavai biztonságosan vannak tárolva (nem plain text) (0/3 pont)
#### Bejelentkezés szabályos session kezeléssel - 10 pont (elérve: 10)
- [x] Van lehetőség az oldalra való bejelentkezésre (0/2 pont)
- [x] Ha bejelentkezéskor rossz adatokat adunk meg, akkor megfelelő hibaüzenetet kapunk (0/2
pont)
- [x] A bejelentkezett felhasználó olyan (értelmes) oldal(aka)t is elér, amely(ek)et a nem bejelentkezett felhasználó nem (0/2 pont)
- [x] A bejelentkezéshez kötött oldal(ak) nem elérhető(ek), csak a bejelentkezett felhasználóknak, különben átirányít a bejelentkezéshez (0/2 pont)
- [x] Működő kijelentkezés (0/2 pont)
#### Bejelentkezéshez kötött funkciók - 52 pont (elérve: 0)
- [ ] A felhasználónak van lehetősége néhány adatának módosítására (pl. jelszó, születési dátum, bemutatkozás, stb.) (0/2/4 pont)
- [ ] A felhasználó tud profilképet feltölteni magának, ez a szerveren eltárolódik, le is tudja
cserélni, illetve az oldalon meg is jelenik (0/2/4 pont)
- [ ] A felhasználó tudja törölni a felhasználói fiókját, ilyenkor az összes adata törlődik (0/4
pont)
- [ ] A felhasználó meg tudja tekinteni más felhasználók profilját / publikus adatait (pl. felhasználónév, profilkép, leírás, stb.), továbbá beállítható, hogy milyen adatokat szeretnénk
publikusan elérhetővé tenni (0/4/8 pont)
- [ ] A felhasználó különböző interakcióba léphet a weboldallal, ennek következményei vannak,
melyek újbóli bejelentkezés után is megmaradnak (pl. termékeket tud kosárba helyezni,
filmeket értékelni 1-5 csillaggal (és ezeket látja is, hogy mennyire értékelte korábban),
ismerősként vehet fel más felhasználókat, stb.) (0/4/8 pont)
- [ ] A felhasználó tud üzenetet küldeni a többi felhasználónak (vagy néhány felhasználónak),
akik ezt láthatják, és válaszolni tudnak neki (0/4/8 pont)
- [ ] Meg vannak valósítva különböző jogosultsági szintek (pl. felhasználó, admin). Az egyes
jogosultsági szinttel rendelkező felhasználók több funkciót elérnek (pl. az admin tud
letiltani felhasználókat, látja a rendeléseket, stb.) (0/4/8 pont)
- [ ] Egyéb, a felsoroltakban nem szereplő, megvalósított funkciók (0/4/8 pont)


A bejelentkezéshez kötött funkciók esetében a maximális pont akkor jár, ha az az adott funkció
igényesen van megvalósítva. Az adott pontnak csak minimálisan megfelelő funkciók csak a
pontszám felét érik. A rosszul működő funkciókra nem jár pont (pl. ha az üzenetek többször
is elküldésre kerülnek).


### Összeg: 41 pont [20 pont/fő]
