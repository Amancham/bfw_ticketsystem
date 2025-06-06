# # Auftragsarbeit: Ticketsystem

Das Programm ist ein Ticketsystem für die Supportarbeit in kleineren Teams.

## Installation

Alle Dateien und die gesamte Datenstrukur direkt in den html oder www Ordner auf dem Server laden oder dort in einen Unterordner, wenn gewünscht. Anschließend rufen sie den Ordner im Browser auf. Die Angabe index.php ist nicht nötig. 

Das System fragt nun nach den Login-Daten für die Datenbank. Geben Sie den Host, den Namen des Datenbankbenutzers und das Passwort sowie die gewünschte Datenbank an. Die Tabellen werden anschließend automatisch installiert und das Skript zeigt ein weiteres Formular an, mit dem man den Admin-User erstellen kann. Geben sie den gewünschten Usernamen, Email und Passwort ein. Das Admin-Konto wird erstellt und das Skript leitet nach erfolgreicher Installation auf die Startseite weiter.

Falls sie das Skript erneut aufrufen wollen, um die Tabellen und das Admin-Konto neu zu installieren, müssen Sie erst die Datei "lock" im Installations-Ordner löschen.

## Weitere Benutzer anlegen 

Auf der Startseite sehen Sie einen Login-Screen und oben rechts einen Link "Konto erstellen". Klicken Sie auf den Link und geben sie alle Daten ein. Der Benutzer wird in der Datenbank angelegt und automatisch direkt eingeloggt.

## Abmelden und einloggen 

Um sich abzumelden, klicken sie den Link "Abmelden" im Menü. 
Zum Einloggen geben Sie die Email-Adresse und das Passwort des entsprechenden Benutzerkontos ein. 

Tickets jeglicher Art sind nur für eingeloggte Benutzer einsehbar.

## Erklärung zu den Benutzerrollen 

Es gibt drei Rollen im System. 

### user 
Dies ist die Standardrolle. Alle neue Konten sind erst mal normale Benutzer. Benutzer können Tickets erstellen, ihre eigenen Tickets einsehen und Notizen zu ihren eigenen Tickets hinzufügen.

### supporter 
Die Supporter können alle offenen Tickets einsehen, neue Tickets erstellen, Tickets bearbeiten, um den Status, die Dringlichkeit oder die Kategorie zu ändern, und Notizen zu Tickets hinzufügen.

### admin 
Administratoren haben Zugriff auf die Statistik und die Benutzerverwaltung. Außerdem können sie alle Tickets einsehen und ebenfalls offene Tickets bearbeiten und Notizen zu Tickets hinzufügen.

## Benutzer-Rollen ändern

Um einen Benutzer zu einem Supporter oder einem Admin zu machen, müssen sie mit dem Admin-Konto eingeloggt sein, das Sie bei der Installation erstellt haben. Klicken sie auf die Benutzerverwaltung.

Wählen Sie in der Liste der registrierten Benutzer den Benutzer aus, den sie ändern möchten und wählen sie die neue Rolle im Dropdown aus. Klicken Sie auf Speichern, um die Änderung zu übernehmen.

## Kategorien erstellen 

Admins können jederzeit weitere Kategorien hinzufügen. Auf der Seite 'Kategories' muss man im Formular nur den Kategorie-Namen eintragen und abschicken. Anschließend ist die neue Kategorie für neue Tickets verfügbar. Es muss unbedingt mindestens eine Kategorie erstellt werden, in die Tickets eingeteilt werden.

## Ticket erstellen

Über den Link 'Ticket erstellen' können alle Benutzer ein Ticket einreichen. Auch Support-Mitarbeiter und Admins. Füllen Sie alle Felder aus und drücken sie auf 'abschicken'. Das Ticket erscheint im Anschluss auf Ihrer Homeseite. Dort können Ticketersteller auch weitere Details und Infos als Kommentare abgeben und Supporter können Antworten schicken. 

## Status eines Tickets ändern

Tickets haben beim Erstellen automatisch den Status 'neu'. Mitarbeiter im Support Team und Admins haben beim Kommentieren die Möglichkeit, den Status auf 'in_bearbeitung' oder 'abgeschlossen' zu setzen. Abgeschlossene Tickets werden nur noch dem Ersteller und den Admins angezeigt, um die Übersicht für die Mitarbeiter nicht zu verstopfen. 

## Ticketpriorität

Die Priorität wird vom Ersteller des Tickets festgelegt. Wenn ein Ticket länger als 7 Tage nicht als abgeschlossen markiert ist, wird die Priorität automatisch eine Stufe höher gestellt.

## Statistiken 

um einen besseren Überblick zu bekommen, haben Admins die Option, sich eine kleine Statistik anzusehen. Hier werden drei verschiedene Bereiche dargestellt. 

### Durchschnittliche Bearbeitungszeit 

Hier wird berechnet, wie lange es im Durchschnitt dauert, ein Ticket zu bearbeiten und zu schließen. 

### Verhältnis offen:bearbeitet 

Um zu sehen, wie das Ticket-Verhältnis aussieht, werden hier die Anzahl und Prozent der Offenen und geschlossenen Tickets angezeigt. 

### Meistaktive Benutzer 

Hier werden die Support-Mitarbeiter und Admins angezeigt, die an den meisten Tickets mitgearbeitet haben. (standardmäßig die 5 aktivsten).