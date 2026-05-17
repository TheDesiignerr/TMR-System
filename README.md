# TMR-System

Distributed telemetry and internet-scale data collection system built around a fault-tolerant multi-worker architecture, centralized state coordination, and time-series analytics.

This system was designed to explore large-scale network data ingestion, distributed worker orchestration, and resilient long-running crawler design using lightweight infrastructure components.

---

## ⚙️ System Overview

TMR-System operates as a distributed collection of independent worker processes that coordinate through a centralized database.

Instead of relying on traditional schedulers or orchestration frameworks, the system uses **state-driven execution**, allowing workers to operate autonomously while remaining synchronized through shared persistent state.

---

## 🚀 Key Features

### 🌐 Distributed Worker Architecture
- Multi-node crawler system (local machine + VPS instances)
- Independent PHP CLI worker processes
- Stateless execution with centralized coordination layer
- Horizontal scaling via additional worker nodes

---

### 📡 Internet-Scale Data Ingestion
- Large-scale IPv4 space scanning and server discovery
- Continuous crawling and re-validation of known entities
- High-volume network observation pipeline

---

### 📊 Time-Series Telemetry & Analytics
- Centralized MariaDB storage (7GB+ dataset scale)
- Tracking of:
  - Uptime / downtime patterns
  - Version distribution
  - Player activity trends
- Historical snapshot system for long-term analysis

---

### 🛠 Fault Tolerance & Self-Healing
- Automatic worker recovery on failure
- Retry mechanisms for unstable or unreachable targets
- Process watchdog logic for long-running stability
- Resilient execution under network instability and malformed responses

---

### 🔔 Event-Driven Webhook Pipeline
- Real-time updates for:
  - newly discovered entities
  - state changes
  - snapshot updates
- External notification system via webhooks
- Lightweight event propagation layer

---

## 🧠 Architecture Philosophy

TMR-System was designed under the following principles:

- Minimal dependencies
- Infrastructure-first design
- State-driven execution over centralized orchestration
- Resilience over complexity
- Long-running autonomous workers

The system prioritizes operational stability under unpredictable network conditions rather than strict architectural formalism.

---

## 🧱 Tech Stack

- PHP (CLI + backend logic)
- MariaDB
- Linux (system-level execution environment)
- Bash / tmux worker orchestration
- HTTP webhook integrations

---

## 📦 Components

- **Crawler Workers** → distributed data collection processes  
- **Updater Engine** → state refresh and data reconciliation  
- **Trend Analyzer** → time-series aggregation system  
- **Webhook Dispatcher** → external event notification system  
- **Central Database** → shared state and analytics storage  

---

## 📈 Scale (historical)

- 3–5 distributed worker nodes
- 7GB+ central dataset
- Continuous long-running ingestion cycles
- Large-scale IPv4 space coverage
- Persistent multi-day runtime operations

---

## 🧩 Design Notes

- No external orchestration frameworks used
- Workers operate independently via CLI execution
- Coordination achieved through database state transitions
- Designed for resilience in unstable network environments

---

## ⚠️ Disclaimer

This project is a research-oriented distributed system built for studying large-scale data ingestion, worker orchestration, and network telemetry behavior.

It is not intended for malicious use or exploitation of services.

---

## 📌 Status

Archived / Research System
