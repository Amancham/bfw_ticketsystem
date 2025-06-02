CREATE TABLE IF NOT EXISTS user (
    uid INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    pwreset INT DEFAULT 0,
    role ENUM('user', 'support', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS category (
    cid INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS ticket (
    tid INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    priority INT CHECK (priority BETWEEN 1 AND 3),
    status ENUM('neu', 'in_bearbeitung', 'abgeschlossen') DEFAULT 'neu',
    uid INT,
    cid INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (uid) REFERENCES user(uid),
    FOREIGN KEY (cid) REFERENCES category(cid)
);

CREATE TABLE IF NOT EXISTS ticket_note (
    nid INT AUTO_INCREMENT PRIMARY KEY,
    tid INT NOT NULL,
    uid INT NOT NULL,
    note TEXT NOT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (tid) REFERENCES ticket(tid),
    FOREIGN KEY (uid) REFERENCES user(uid)
);
CREATE TABLE IF NOT EXISTS ticket_supporter (
    sid INT AUTO_INCREMENT PRIMARY KEY,
    tid INT,
    uid INT,
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tid) REFERENCES ticket(tid),
    FOREIGN KEY (uid) REFERENCES user(uid)
);