# Expert Entity Documentation

## Overview
The Expert entity has been successfully created and integrated into the Jamaity application with full EasyAdmin CRUD functionality.

## Entity Features

### Fields
- **firstName** (string, required): Expert's first name
- **lastName** (string, required): Expert's last name
- **email** (string, required, unique): Expert's email address
- **phoneNumber** (string, required): Expert's phone number
- **linkedin** (string, optional): LinkedIn profile URL
- **description** (text, optional): Brief description about the expert
- **slug** (string, required, unique): URL-friendly identifier
- **birthday** (date, optional): Expert's birth date
- **gender** (string, optional): Gender (male, female, other, not_specified)
- **resume** (string, optional): File path for uploaded resume (PDF, Word, or image)
- **professionalExperience** (JSON array): Array of objects with title and description
- **training** (JSON array): Array of training/certification strings
- **workedWith** (Many-to-Many): Relationship with Organization entities

### File Upload Support
The resume field supports uploading:
- PDF files (.pdf)
- Word documents (.doc, .docx)
- Image files (.jpg, .jpeg, .png)

### Professional Experience Structure
The professionalExperience field stores an array of objects with this structure:
```json
[
  {
    "title": "Senior Developer",
    "description": "Led development team and implemented new features"
  },
  {
    "title": "Project Manager",
    "description": "Managed multiple projects and coordinated with stakeholders"
  }
]
```

### Training Structure
The training field stores a simple array of strings:
```json
[
  "Certified Scrum Master",
  "AWS Solutions Architect",
  "Project Management Professional (PMP)"
]
```

## EasyAdmin Integration

### CRUD Controller
The `ExpertCrudController` provides:
- Tabbed interface (Personal Information, Professional Information, Organizations)
- File upload functionality for resumes
- Array field management for professional experience and training
- Association management for organizations
- Proper field validation and formatting

### Admin Menu
The Expert entity has been added to the EasyAdmin dashboard menu with:
- Icon: `fas fa-user-tie`
- Label: "Experts"

## Database Migration
A migration file has been created (`Version20250116000000.php`) that:
- Creates the `expert` table with all required fields
- Creates the `expert_organization` junction table for many-to-many relationships
- Sets up proper foreign key constraints
- Includes unique indexes for email and slug fields

## Repository Methods
The `ExpertRepository` includes useful query methods:
- `findByOrganization($organization)`: Find experts by organization
- `findByTraining($training)`: Find experts with specific training
- `searchExperts($query)`: Search experts by name or description
- `findByGender($gender)`: Find experts by gender

## Usage Instructions

### To run the migration:
```bash
php bin/console doctrine:migrations:migrate
```

### To access the Expert CRUD:
1. Navigate to `/admin` in your browser
2. Click on "Experts" in the sidebar menu
3. Use the interface to create, read, update, and delete expert records

### Adding Professional Experience:
1. In the "Professional Information" tab
2. Use the array field to add title/description pairs
3. Each entry represents one professional experience

### Adding Training:
1. In the "Professional Information" tab
2. Use the training array field to add certification/training names
3. Each entry is a simple string

### Uploading Resume:
1. In the "Professional Information" tab
2. Use the file upload field to select resume file
3. Supported formats: PDF, Word documents, images

### Linking Organizations:
1. In the "Organizations" tab
2. Use the autocomplete field to select organizations
3. Multiple organizations can be selected

## File Structure
```
src/
├── Entity/
│   └── Expert.php                    # Main entity class
├── Repository/
│   └── ExpertRepository.php          # Repository with custom queries
├── Controller/Admin/
│   └── ExpertCrudController.php      # EasyAdmin CRUD controller
└── Form/
    └── ProfessionalExperienceType.php # Form type for experience entries

migrations/
└── Version20250116000000.php         # Database migration
```

## Notes
- The entity follows Symfony and Doctrine best practices
- All fields have proper validation and type hints
- The slug field is automatically generated from firstName
- File uploads are handled through Symfony's file upload system
- JSON fields provide flexibility for complex data structures
- Many-to-many relationship allows experts to be associated with multiple organizations