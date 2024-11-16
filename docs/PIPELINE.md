# CircleCI Pipeline Documentation

## Pipeline Overview

This CircleCI pipeline implements a comprehensive CI/CD workflow for PHP applications with security checks, testing, and deployment capabilities.

```mermaid
flowchart LR
  A[🛠️ build-setup]
  B[📦 build-docker-image]
  C[🧹 lint-phpcs]
  D[🔒 security-check-dependencies]
  E[🧪 test-phpunit]
  F[📊 metrics-sonarqube]
  G[📈 metrics-phpmetrics]
  H[🛡️ security-scan-grype]
  I[🔑 setup-infisical]
  J[⏸️ hold]
  K[🚀 deploy-ssh-production]
  L[🚀 deploy-ssh-staging]

  A --> B
  A --> C
  A --> D
  A --> E
  A --> G
  E -- coverage.xml --> F
  B --> H
  C --> J
  D --> J
  E --> J
  F --> J
  G --> J
  H --> J
  I -- secrets --> J
  J -- secrets --> K
  J -- secrets --> L
```

## Deployment Flow

```mermaid
flowchart LR
    subgraph Local
        U[👤 User]
    end

    U -- push --> G

    subgraph Github
        G[💻 GitHub]
    end

    G -- triggers --> P[🔁 Circle CI Action]

    subgraph CircleCI
        P --> M[📊 Send metrics to SonarQube]
        P --> I[📦 Build and push Docker image to GHCR]
        P --> OVH[⚙️ Deploy to **O**zeliurs **V**irtual **H**osting - Staging]
        P --> AWS[⚙️ Deploy to AWS - Production]
    end

    subgraph External_Services
        M -- pushes --> SQ[📊 SonarQube]
        I -- pushes --> GHCR[🗄️ GitHub Container Registry]
    end

    subgraph Deployment
        C1[💻 Execute pull command on OVH host]
        C2[💻 Execute pull command on AWS host]
        OVH <--> C1
        AWS <--> C2
        C1 <--> GHCR
        C2 <--> GHCR
    end
```

## Pipeline Jobs Description

1. **build-setup** 🛠️
   - Installs PHP dependencies
   - Caches vendor directory
   - Sets up the initial workspace

2. **build-docker-image** 📦
   - Builds Docker image
   - Pushes to GitHub Container Registry
   - Tags with branch name and commit hash

3. **Quality & Security Checks**
   - **lint-phpcs** 🧹: PHP CodeSniffer checks
   - **security-check-dependencies** 🔒: Security vulnerability scanning
   - **test-phpunit** 🧪: Unit testing with coverage
   - **metrics-sonarqube** 📊: Code quality analysis
   - **metrics-phpmetrics** 📈: PHP metrics generation
   - **security-scan-grype** 🛡️: Container security scanning

4. **Deployment Process**
   - **setup-infisical** 🔑: Manages environment secrets
   - **hold** ⏸️: Manual approval gate
   - **deploy-ssh-production** 🚀: Production deployment
   - **deploy-ssh-staging** 🚀: Staging deployment

## Environment and Branches

- Production deployments: `main` and `master` branches
- Staging deployments: `release/*` branches
- Automated testing: All branches
