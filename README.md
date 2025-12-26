# WooMagicLogin
Registrazione e accesso con magic link per WooCommerce.

Woo Magic Login è un plugin per WordPress e WooCommerce che introduce un sistema di registrazione e accesso senza password basato su **magic link**.  
L’obiettivo è ridurre al minimo la frizione in fase di onboarding, permettendo agli utenti di accedere alla piattaforma in modo semplice, sicuro e immediato.

Il plugin è progettato per integrarsi perfettamente con WooCommerce e con sistemi di gestione associativa come **WooAssociation**.

---

## ✨ Funzionalità principali

### 🔐 1. Registrazione con sola email
L’utente inserisce solo la propria email.  
Se l’account non esiste, viene creato automaticamente con:
- username interno generato casualmente  
- password casuale non utilizzata  
- profilo WooCommerce inizializzato  

Nessun indirizzo, nessun dato aggiuntivo, nessuna password.

### ✉️ 2. Accesso tramite magic link
L’utente riceve un’email contenente un link univoco e temporaneo.  
Cliccando il link:
- viene autenticato automaticamente  
- viene reindirizzato alla pagina “Il mio account”  

Il token è monouso e scade dopo un’ora.

### 🧩 3. Integrazione totale con WooCommerce
Woo Magic Login:
- non crea profili paralleli  
- non modifica il comportamento standard di WooCommerce  
- non interferisce con il checkout  
- non aggiunge campi al profilo  

Tutta la gestione dei dati personali rimane in WooCommerce (o in plugin come Woo Association).

### 🧱 4. Shortcode semplici e modulari
Il plugin fornisce due shortcode:

- `[woomagiclogin_register]` → form di registrazione  
- `[woomagiclogin_login]` → form di accesso  

Possono essere inseriti in qualunque pagina.

### 🔒 5. Sicurezza integrata
- token crittografici generati con funzioni WordPress  
- scadenza automatica  
- cancellazione immediata dopo l’uso  
- nessuna password memorizzata o gestita dall’utente  

---

## 📦 Installazione

1. Copia la cartella `woomagiclogin` in:
wp-content/plugins/
2. Attiva il plugin da:
Bacheca → Plugin
3. Crea due pagine:
- **Registrazione** → `[woomagiclogin_register]`
- **Accesso** → `[woomagiclogin_login]`

4. Assicurati che WooCommerce sia attivo.

---

## ⚙️ Come funziona

### 1. Registrazione
- L’utente inserisce la propria email.  
- Se l’account non esiste, viene creato.  
- Viene inviato un magic link.

### 2. Accesso
- L’utente inserisce la propria email.  
- Se l’account esiste, riceve un magic link.  
- Cliccando il link → login immediato.

### 3. Profilo
Woo Magic Login **non** gestisce dati personali.  
Il completamento del profilo avviene in WooCommerce o tramite plugin come Woo Association.

---

## 🧩 Integrazione con Woo Association

Woo Magic Login è progettato per lavorare in coppia con **Woo Association**, che gestisce:

- completamento profilo  
- adesione associativa  
- quota annuale  
- rinnovo automatico  

Woo Magic Login si occupa solo dell’identità e dell’accesso.

---

## 🌍 Traduzioni

Il plugin include la cartella:
languages/
con il file:
woomagiclogin.pot

Puoi tradurre con:
- Poedit  
- Loco Translate  
- WP‑CLI  

---

## 🧱 Struttura del plugin
woomagiclogin/ 
  woomagiclogin.php 
includes/ 
  class-woomagiclogin-plugin.php 
  class-woomagiclogin-token.php 
  class-woomagiclogin-email.php 
  class-woomagiclogin-auth.php 
  class-woomagiclogin-woocommerce.php 
templates/ 
  form-register.php 
  form-login.php 
languages/ 
  woomagiclogin.pot 
README.md


---

## 🤝 Contributi

Pull request, issue e suggerimenti sono benvenuti.  
Il plugin è pensato per essere estensibile, modulare e integrabile in ecosistemi più ampi.

---

## 📄 Licenza

GNU GPL V.2
