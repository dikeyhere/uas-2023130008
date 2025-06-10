CREATE TABLE airlines (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    icao CHAR(3) NOT NULL,
    name VARCHAR(255) NOT NULL,
    country CHAR(2)
);

CREATE TABLE airports (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    iata CHAR(3) NOT NULL,
    name VARCHAR(255) NOT NULL,
    country CHAR(2) NOT NULL
);

CREATE TABLE flights (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    origin_id INT NOT NULL,
    destination_id INT NOT NULL,
    departure_time DATETIME NOT NULL DEFAULT NOW(),
    arrival_time DATETIME NOT NULL,
    status VARCHAR(255) NOT NULL DEFAULT 'SCHEDULED',
    airline_id INT NOT NULL,
    FOREIGN KEY (origin_id) REFERENCES airports(id),
    FOREIGN KEY (destination_id) REFERENCES airports(id),
    FOREIGN KEY (airline_id) REFERENCES airlines(id)
);

INSERT INTO airlines (icao, name, country) VALUES
('GIA', 'Garuda Indonesia', 'ID'),
('SIA', 'Singapore Airlines', 'SG'),
('QFA', 'Qantas', 'AU'),
('CES', 'China Eastern Airlines', 'CN'),         
('MAS', 'Malaysia Airlines', 'MY'),              
('KAL', 'Korean Air', 'KR'),
('ANA', 'All Nippon Airways', 'JP'),
('THA', 'Thai Airways International', 'TH'),
('CPA', 'Cathay Pacific Airways', 'HK'),
('UAE', 'Emirates', 'AE');
         
INSERT INTO airports (iata, name, country) VALUES
('CGK', 'Soekarno-Hatta International Airport', 'ID'),
('SIN', 'Singapore Changi Airport', 'SG'),
('SYD', 'Sydney Kingsford Smith Airport', 'AU'),
('PEK', 'Beijing Capital International Airport', 'CN'),
('KUL', 'Kuala Lumpur International Airport', 'MY'),      
('ICN', 'Incheon International Airport', 'KR'),
('NRT', 'Narita International Airport', 'JP'),
('BKK', 'Suvarnabhumi Airport', 'TH'),
('HKG', 'Hong Kong International Airport', 'HK'),
('DXB', 'Dubai International Airport', 'AE');
   

