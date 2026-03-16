Part 1: Normalization
Task 1: Identify Violation
Data Redundancy: Columns such as CourseID, CourseName, ProfessorName, ProfessorEmail, and Grade are responsible for significant data duplication. Database design principles dictate that each table should focus on a single functional entity (3NF). Currently, this flat table incorrectly bundles three distinct types of data: student profiles, course catalog details, and faculty information alongside enrollment grades.

Update Anomalies:

Faculty Contact Info: Since each professor's email is unique, ProfessorEmail is functionally dependent on ProfessorName. If a lecturer instructs multiple courses and their email changes, every corresponding row must be updated manually. Failure to do so results in data inconsistency.

Course Details: If a course title in the CourseName column is modified, the instructor's name in the ProfessorName column remains unchanged, requiring redundant management across multiple records.

Transitive Dependencies: The schema contains three clear transitive dependencies:

StudentName depends on StudentID (The Primary Key).

CourseName depends on CourseID.

ProfessorEmail relies on ProfessorName.

Grade is contingent upon both StudentID and CourseID.



Task 2: Decompose to 3NF
We will restructure the original dataset into four specialized tables to ensure functional singleness. The proposed schema includes: Students, Courses, Professors, and Enrollments.

| Table Name | Primary Key | Foreign Key | Normal Form | Description |

| Students | StudentID | None| 3NF | Stores student information|

| Courses | CourseID | None | 3NF | Stores course details |

| Professors | ProfessorID | None | 3NF | Holds instructor's data | 

| Enrollments | EnrollmentID | StudentID, CourseID, ProfessorID | 3NF | Course enrollment of students |



Part 2: Relationship Drills
1.Author — Book

Relationship type: Many-to-Many (M:N). An author can produce numerous books, and a single book can be co-authored by multiple writers.

FK location: Located in a junction table containing BookID and AuthorID.

2.Citizen — Passport

Relationship type: One-to-Many (1:N). A citizen may hold multiple passports if they possess multiple nationalities; however, each individual passport is strictly assigned to only one person.

FK location: CitizenID in the Passports table references CitizenID (PK) in the Citizens table.

3.Customer — Order

Relationship type: One-to-Many (1:N). A customer at a supermarket can make multiple separate purchases (orders) throughout the day. Each specific order, however, is linked to only the one buyer who paid the bill.

FK location: CustomerID in the Orders table references CustomerID (PK) in the Customers table.

4.Student — Class

Relationship type: Many-to-Many (M:N). A student can enroll in various classes, and each class is composed of many students.

FK location: Implemented via a junction table (e.g., Enrollments) containing StudentID and ClassID as foreign keys.

5.Team — Player

Relationship type: One-to-Many (1:N). A team consists of a group of many players, but a player is legally permitted to play for only one team at any given time.

FK location: TeamID in the Players table references TeamID (PK) in the Teams table.


