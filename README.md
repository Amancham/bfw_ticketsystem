# Auftragsarbeit: Ticketsystem

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