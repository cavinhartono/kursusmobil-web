-- Active: 1734018196245@@127.0.0.1@3306

CREATE DATABASE driving_school;

USE driving_school;

CREATE TABLE Instructors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES Users(id)
);

CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    duration INT NOT NULL, -- Duration in hours
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    car_id INT NOT NULL, 
    instructor_id INT NOT NULL,
    enrollment_id INT NOT NULL,
    date DATE NOT NULL,
    time_in TIME NOT NULL,
    time_out TIME NOT NULL,

    FOREIGN KEY (car_id) REFERENCES Cars (id),
    FOREIGN KEY (instructor_id) REFERENCES Instructors (id),
    FOREIGN KEY (enrollment_id) REFERENCES Enrollments (id)
);

CREATE TABLE enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    date DATE NOT NULL,
    time_in TIME NOT NULL,
    time_out TIME NOT NULL,
    enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES Users (id),
    FOREIGN KEY (course_id) REFERENCES Courses (id)
);

CREATE TABLE cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    transmission ENUM('manual', "automatic") NOT NULL,
    status ENUM("active", "non-active") DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE certifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    generate_code VARCHAR(50),
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    instructor_id INT NOT NULL,
    date_of_issue DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (student_id) REFERENCES Users(id),
    FOREIGN KEY (course_id) REFERENCES Courses(id),
    FOREIGN KEY (instructor_id) REFERENCES Instructors(id)
);

CREATE TABLE Exams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    enrollment_id INT,
    instructor_id INT,
    grade INT CHECK (grade BETWEEN 0 AND 100),
    notes TEXT,
    date DATE DEFAULT CURRENT_DATE,
    FOREIGN KEY (enrollment_id) REFERENCES enrollments (id),
    FOREIGN KEY (instructor_id) REFERENCES users (id)
);

CREATE TABLE Master_Cards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    serial_number VARCHAR(50) NOT NULL,
    name VARCHAR(50) NOT NULL,
    balance FLOAT NOT NULL
);

CREATE TABLE Orders();

CREATE TABLE Orders();

-- Insert data ke dalam tabel `students`
INSERT INTO users (roles, name, email, password, phone) VALUES
('student', 'Ahmad Fauzi', 'ahmad.fauzi@email.com', 'ahmad123', '081234567890'),
('student', 'Budi Santoso', 'budi.santoso@email.com', 'budi123', '081234567891'),
('student', 'Citra Lestari', 'citra.lestari@email.com', 'citra123', '081234567892'),
('student', 'Dewi Permata', 'dewi.permata@email.com', 'dewi1234', '081234567893'),
('student', 'Eko Saputra', 'eko.saputra@email.com', 'eko12345', '081234567894');

INSERT INTO users (roles, name, email, password, phone) VALUES
('admin', 'Muhammad Cavin Hartono Putra', 'cavin@email.com', 'cavin123', '081234567889'),
('admin', 'Fauzi Riza Wahyudi', 'fauzi@email.com', 'fauzi123', '081234567888'),
('student', 'Ahmad Fauzi', 'ahmad.fauzi@email.com', 'ahmad123', '081234567890'),
('student', 'Budi Santoso', 'budi.santoso@email.com', 'budi123', '081234567891'),
('student', 'Citra Lestari', 'citra.lestari@email.com', 'citra123', '081234567892'),
('student', 'Dewi Permata', 'dewi.permata@email.com', 'dewi1234', '081234567893'),
('instructor', 'Faisal Hadi', 'faisal.hadi@email.com', 'faisal123', '081234567895'),
('instructor', 'Gina Ananda', 'gina.ananda@email.com', 'gina1234','081234567896'),
('instructor', 'Hendra Wijaya', 'hendra.wijaya@email.com', 'hendra123', '081234567897'),
('student', 'Eko Saputra', 'eko.saputra@email.com', 'eko12345', '081234567894');

-- Insert data ke dalam tabel `instructors`
INSERT INTO master_cards (serial_number, name, balance) VALUES
("255", "Muhammad Cavin Hartono Putra", 12000000),
("174", "Fauzi Riza Wahyudi", 300000),
("696", "Budi Utomo", 4000000);

INSERT INTO instructors (name, email, phone) VALUES
('Faisal Hadi', 'faisal.hadi@email.com', '081234567895'),
('Gina Ananda', 'gina.ananda@email.com', '081234567896'),
('Hendra Wijaya', 'hendra.wijaya@email.com', '081234567897');

-- Insert data ke dalam tabel `courses`
INSERT INTO courses (name, duration, price) VALUES
('Kursus Mengemudi Dasar', 10, 750000.00),
('Kursus Mengemudi Lanjutan', 15, 1000000.00),
('Kursus Parkir Paralel', 5, 500000.00);

-- Insert data ke dalam tabel `cars`
INSERT INTO cars (name, transmission) VALUES
('Toyota Avanza', 'automatic'),
('Honda Brio', 'manual'),
('Suzuki Swift', 'manual');

-- Insert data ke dalam tabel `enrollments`
INSERT INTO enrollments (student_id, course_id, car_id, instructor_id) VALUES
(1, 1, 1, 1),
(2, 2, 2, 2),
(3, 3, 3, 3),
(4, 1, 2, 1),
(5, 2, 3, 2);

ALTER TABLE Enrollments ADD COLUMN time_in TIME NOT NULL;

ALTER TABLE Cars ADD COLUMN status ENUM("active", "non-active") DEFAULT 'active';

ALTER TABLE Enrollments ADD COLUMN date DATE;

ALTER TABLE Enrollments ADD COLUMN time_out TIME NOT NULL;

CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    roles ENUM('student', "instructor", "admin") DEFAULT 'student',
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(100),
    phone VARCHAR(15),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DELIMITER //
CREATE TRIGGER trg_after_user_insert
AFTER INSERT ON users
FOR EACH ROW
BEGIN
    IF NEW.roles = 'instructor' THEN
        INSERT INTO instructors (user_id)
        VALUES (NEW.id);
    END IF;
END;
// DELIMITER;

CREATE TRIGGER trg_after_user_update
AFTER UPDATE ON users
FOR EACH ROW
BEGIN
    IF NEW.roles = 'instructor' AND OLD.role != 'instructor' THEN
        INSERT INTO instructors (user_id)
        VALUES (NEW.id)
    END IF;
END;
// DELIMITER;

SELECT 9 AS user_id, "Sukses" AS status, 5 AS course_id, 7500000.00 AS total_price;

SELECT "Kevin Hartono" AS "Pengemudi", "Sukses" AS status, "qris" AS "Metode Pembayaran", "Kursus Mengemudi Dasar" AS "Kursus", 750000.00 AS "Harga", "27-04-2025 22:10:39" AS "Waktu Transaksi";