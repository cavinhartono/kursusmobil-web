-- Active: 1734018196245@@127.0.0.1@3306

CREATE DATABASE driving_school;

USE driving_school;

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(15) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE instructors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(15) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    duration INT NOT NULL, -- Duration in hours
    price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    car_id INT NOT NULL,
    instructor_id INT NOT NULL,
    enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (car_id) REFERENCES cars (id),
    FOREIGN KEY (student_id) REFERENCES students (id),
    FOREIGN KEY (course_id) REFERENCES courses (id),
    FOREIGN KEY (instructor_id) REFERENCES instructors (id)
);

CREATE TABLE cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    transmission ENUM('manual', "automatic") NOT NULL,
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
    FOREIGN KEY (student_id) REFERENCES students (id),
    FOREIGN KEY (course_id) REFERENCES courses (id),
    FOREIGN KEY (instructor_id) REFERENCES instructors (id)
);

-- Insert data ke dalam tabel `students`
INSERT INTO students (name, email, phone) VALUES
('Ahmad Fauzi', 'ahmad.fauzi@email.com', '081234567890'),
('Budi Santoso', 'budi.santoso@email.com', '081234567891'),
('Citra Lestari', 'citra.lestari@email.com', '081234567892'),
('Dewi Permata', 'dewi.permata@email.com', '081234567893'),
('Eko Saputra', 'eko.saputra@email.com', '081234567894');

-- Insert data ke dalam tabel `instructors`
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
