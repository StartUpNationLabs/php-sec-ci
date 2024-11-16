# PHP Security CI Example

[![Quality Gate Status](https://sonarqube.devops-tools.apoorva64.com/api/project_badges/measure?project=php-sec-ci&metric=alert_status&token=sqb_0a7ea53df1c7d83ddb4de98a45356cad9767f990)](https://sonarqube.devops-tools.apoorva64.com/dashboard?id=php-sec-ci)
[![Security Rating](https://sonarqube.devops-tools.apoorva64.com/api/project_badges/measure?project=php-sec-ci&metric=security_rating&token=sqb_0a7ea53df1c7d83ddb4de98a45356cad9767f990)](https://sonarqube.devops-tools.apoorva64.com/dashboard?id=php-sec-ci)
[![Reliability Rating](https://sonarqube.devops-tools.apoorva64.com/api/project_badges/measure?project=php-sec-ci&metric=reliability_rating&token=sqb_0a7ea53df1c7d83ddb4de98a45356cad9767f990)](https://sonarqube.devops-tools.apoorva64.com/dashboard?id=php-sec-ci)
[![Maintainability Rating](https://sonarqube.devops-tools.apoorva64.com/api/project_badges/measure?project=php-sec-ci&metric=sqale_rating&token=sqb_0a7ea53df1c7d83ddb4de98a45356cad9767f990)](https://sonarqube.devops-tools.apoorva64.com/dashboard?id=php-sec-ci)
[![Coverage](https://sonarqube.devops-tools.apoorva64.com/api/project_badges/measure?project=php-sec-ci&metric=coverage&token=sqb_0a7ea53df1c7d83ddb4de98a45356cad9767f990)](https://sonarqube.devops-tools.apoorva64.com/dashboard?id=php-sec-ci)

This project demonstrates a complete CI/CD pipeline for a PHP application with robust security measures and best practices.

## 🛠️ Technical Stack

- PHP 8.2 & Composer
- Docker

## 🚀 Getting Started

Pull and Run the docker image

```bash
docker run -p 8080:80 ghcr.io/startupnationlabs/php-sec-ci:main
```

Then navigate to `http://localhost:8080` in your browser.

## 🐳 Build Locally your version

Build the image:
```bash
docker build -f docker/Dockerfile -t php-sec-ci .
```

Run the container:
```bash
docker run -p 8080:80 php-sec-ci
```

## 🔄 CI/CD Pipeline

The project includes a comprehensive CircleCI pipeline that builds, tests and deploys the application.

To learn more about the pipeline, refer to the [`docs/PIPELINE.md`](docs/PIPELINE.md) file.

## 📊 Quality Metrics

Code is scanned for quality and security issues using SonarQube. Coverage is also measured and reported.

SonaQube is available at [https://sonarqube.devops-tools.apoorva64.com](https://sonarqube.devops-tools.apoorva64.com/dashboard?id=php-sec-ci).

## 🔒 Security

We use grype to scan the container image for vulnerabilities. The results are published in the CircleCI pipeline.

## 📄 License

This project is proprietary and all rights are reserved.

## 👥 Contributing

Please refer to the project's style and contribution guidelines for submitting patches and additions. In general, follow the "fork-and-pull" Git workflow.

## 📞 Support

For support, please open an issue in the repository's issue tracker.
