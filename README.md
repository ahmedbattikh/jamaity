# Jamaity - Symfony EasyAdmin Project

This is a Symfony project with EasyAdmin for managing organizations, events, and opportunities in Tunisia.

## Features

- **Organizations Management**: Associations, Coalitions, and PTF (Platform)
- **Events Management**: Event creation and organization linking
- **Opportunities Management**: Funding and collaboration opportunities
- **EasyAdmin Interface**: User-friendly admin panel

## Docker Setup

### Prerequisites

- Docker
- Docker Compose

### Getting Started

1. **Clone the repository** (if not already done)

2. **Build and start the containers**:
   ```bash
   docker-compose up -d --build
   ```

3. **Install dependencies** (if not already installed):
   ```bash
   docker-compose exec backend composer install
   ```

4. **Create the database**:
   ```bash
   docker-compose exec backend php bin/console doctrine:database:create
   ```

5. **Run migrations**:
   ```bash
   docker-compose exec backend php bin/console doctrine:migrations:migrate
   ```

6. **Access the application**:
   - Main application: http://localhost:8081
   - EasyAdmin panel: http://localhost:8081/admin

### Services

- **web**: Apache HTTP Server (Frontend/Proxy)
  - Port: 8080
  - Serves static files and proxies PHP requests to backend

- **backend**: Symfony application (PHP 8.2-FPM)
  - Port: 9000 (internal)
  - Volume: Current directory mounted to `/var/www/html`
  - Handles all PHP processing and Symfony operations

- **database**: MySQL 8.0
  - Port: 3306
  - Database: `jamaity`
  - Username: `root`
  - Password: `password`

### Useful Commands

```bash
# View logs
docker-compose logs -f

# Access backend container shell (for Symfony commands)
docker-compose exec backend bash

# Access web container shell (for static files)
docker-compose exec web sh

# Access MySQL
docker-compose exec database mysql -u root -p jamaity

# Stop containers
docker-compose down

# Rebuild containers
docker-compose up -d --build

# Clear Symfony cache
docker-compose exec backend php bin/console cache:clear

# Run Symfony console commands
docker-compose exec backend php bin/console [command]

# Install/update Composer dependencies
docker-compose exec backend composer install
```

## Entities

### Organization (Abstract Base Class)
- `id`: Primary key
- `slug`: URL-friendly identifier
- `logo`: Organization logo
- `contactInformation`: Contact details
- `description`: Organization description
- `visAVis`: Vis-à-vis information
- `coordinates`: Geographic coordinates
- `events`: Many-to-many relationship with events

### Association (extends Organization)
- `titre`: Association title
- `numeroJort`: JORT number
- `adresse`: Address
- `president`: President name
- Contact information (email, telephone, fax)
- Social media links
- `anneeFondation`: Foundation year
- `siteWeb`: Website
- `structure`: Organization structure
- `parent`: Self-referencing parent association
- `domaine`: Domain of activity
- `descriptionPresentation`: Presentation description

### Coalition (extends Organization)
- `titre`: Coalition title
- `adresse`: Address
- `abreviation`: Abbreviation
- `lieux`: Locations
- Contact information
- Social media links
- `siteWeb`: Website
- `domaine`: Domain of activity

### PTF - Platform (extends Organization)
- `titre`: Platform title
- `annee`: Year
- `adresse`: Address
- `abreviation`: Abbreviation
- `lieux`: Locations
- `mission`: Mission statement
- Contact information
- Social media links
- `siteWeb`: Website
- `prioritesStrategiques`: Strategic priorities
- `missionThemePrioritaire`: Priority mission theme
- Contact person details
- `domaine`: Domain (with predefined choices)
- `priorites`: Priorities array

### Event
- `titre`: Event title
- `description`: Event description
- `dateDebut`: Start date
- `dateFin`: End date
- `lieu`: Location
- `detailEvenement`: Event details
- `image`: Event image
- `statut`: Status (Active, Inactive, Cancelled)
- `organizations`: Many-to-many relationship with organizations

### Opportunity
- `titre`: Opportunity title
- `opportunityDetails`: Detailed description
- `eligibilityCriteria`: Eligibility criteria (array)
- `howToApply`: Application instructions
- `dueDate`: Application deadline
- `typeOfOpportunities`: Type (Funding, Training, etc.)
- `regions`: Target regions (array)
- `interventionThemes`: Intervention themes (array)
- `organisme`: Organizing body
- Timestamps and status
- Contact information
- `budget`: Budget information
- `siteWeb`: Website

## Development

The project uses:
- **Symfony 7.x**: PHP framework
- **EasyAdmin 4.x**: Admin interface
- **Doctrine ORM**: Database abstraction
- **MySQL 8.0**: Database
- **Docker**: Containerization

## Environment Variables

Key environment variables in `.env`:
- `APP_ENV`: Application environment (dev/prod)
- `APP_SECRET`: Application secret key
- `DATABASE_URL`: Database connection string

For Docker setup, the database connection is automatically configured to use the `database` service.