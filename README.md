# TechScout Digest

This project is a SaaS application designed to practice Test-Driven Development (TDD), Behavior-Driven Development (BDD), and Hexagonal Architecture. It is a test project, not intended for production, to experiment with these different methodologies and improve software development skills.

## Installation

To install and run this project locally, please follow the steps below:

### Prerequisites

- Docker and Docker Compose

### Installation Steps

1. **Clone the repository**
   ```bash
   git clone <REPOSITORY_URL>
   cd <PROJECT_NAME>
   ```

2. **Configure the environment**
    - Copy the `.env` file to create a `.env.local` file:
      ```bash
      cp .env .env.local
      ```
    - Modify the environment variables according to your local configuration.

3. **Start Docker containers**
    - Ensure Docker is running, then start the required containers:
      ```bash
      make start
      ```

4. **Access the application**
    - The application should now be accessible at: [https://localhost](https://localhost)

## Project Objectives

This project was created to:

- Practice **Test-Driven Development (TDD)** by writing unit tests before implementing features.
- Experiment with **Behavior-Driven Development (BDD)** to ensure that implemented features meet user expectations.
- Explore **Hexagonal Architecture**, by separating domain, infrastructure, and application logic to make the code more maintainable and adaptable.

## Technologies Used

- **Symfony**: PHP framework used for application development.
- **PHPUnit**: For unit testing and TDD.
- **Behat**: For BDD testing.
- **Docker**: To create an isolated and reproducible environment.

## Useful Commands

- **Run unit tests**:
  ```bash
  make test
  ```

- **Run BDD tests**:
  ```bash
  vendor/bin/behat
  ```

## Contribution

This project is primarily a learning project. Feel free to use it to test, experiment, and improve your skills in TDD, BDD, and Hexagonal Architecture.

## License

This project is licensed under the MIT License. You are free to use and modify it as you see fit.

