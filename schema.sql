CREATE DATABASE CraftBruteDB;
USE CraftBruteDB;

-- Stores crawled IPs without Minecraft server responses
CREATE TABLE known_ips(
    ip INT UNSIGNED NOT NULL PRIMARY KEY,
    time DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
) ENGINE=InnoDB;

-- Stores crawled IPs WITH Minecraft server responses
CREATE TABLE known_servers(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    server_ip INT UNSIGNED NOT NULL,
    server_version VARCHAR(100) NOT NULL,
    server_online INT UNSIGNED NOT NULL,
    server_max INT UNSIGNED NOT NULL,
    server_motd VARCHAR(255) NOT NULL,
    server_status VARCHAR(10) NOT NULL,
    last_seen DATETIME DEFAULT CURRENT_TIMESTAMP,
    first_seen DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
) ENGINE=InnoDB;

-- Stores player amount trends per server
CREATE TABLE player_population(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    server_id INT UNSIGNED NOT NULL, 
    server_players INT UNSIGNED NOT NULL, 
    time DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, 
    FOREIGN KEY (server_id) REFERENCES known_servers(id)
) ENGINE=InnoDB;

-- Stores server uptime per server
CREATE TABLE server_uptime(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    server_id INT UNSIGNED NOT NULL, 
    server_status VARCHAR(7) NOT NULL,
    time DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, 
    FOREIGN KEY (server_id) REFERENCES known_servers(id)
) ENGINE=InnoDB;

-- Stores version trends globally used by all servers
CREATE TABLE version_trends(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    version_name VARCHAR(100) NOT NULL, 
    version_amount INT UNSIGNED NOT NULL, -- Total servers using X version
    time DATE DEFAULT CURRENT_TIMESTAMP NOT NULL
) ENGINE=InnoDB;

-- Stores player trends globally in all servers
CREATE TABLE player_trends(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    player_amount INT UNSIGNED NOT NULL, -- Total players online in all servers
    time DATE DEFAULT CURRENT_TIMESTAMP NOT NULL
) ENGINE=InnoDB;

-- Stores server amount trends globally in all servers
CREATE TABLE server_trends(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    server_amount INT UNSIGNED NOT NULL, -- Total online servers
    time DATE DEFAULT CURRENT_TIMESTAMP NOT NULL
) ENGINE=InnoDB;

-- Stores total crawls and daily crawls
CREATE TABLE stats(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    total_ips INT UNSIGNED NOT NULL,
    total_today INT UNSIGNED NOT NULL,
    time DATE DEFAULT CURRENT_TIMESTAMP NOT NULL
) ENGINE=InnoDB;

INSERT INTO stats(total_ips, total_today) VALUES(0, 0);

CREATE INDEX idx_known_ips ON known_ips(ip);
CREATE INDEX idx_known_servers_ip ON known_servers(server_ip);
CREATE INDEX idx_known_servers_version ON known_servers(server_version);
CREATE INDEX idx_version_trends_name ON version_trends(version_name);
CREATE INDEX idx_version_trends_time ON version_trends(time);
CREATE INDEX idx_player_trends_time ON player_trends(time);
CREATE INDEX idx_server_trends_time ON server_trends(time);
CREATE INDEX idx_stats_time ON stats(time);