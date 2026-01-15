# Security Module

This module is responsible for:

- Phishing detection
- Abnormal user behavior detection
- Risk scoring & decisioning
- Security audit logging
- SOC / Compliance review UI

## Architecture

- UI: Volt (read-only)
- Writes: Actions → Events → Listeners
- Enforcement: Middleware
- Review: Admin-only UI
- Audit: Immutable logs

## Compliance

- Deterministic rules (no black box)
- Explainable risk decisions
- Replayable events
- CI-enforced boundaries

## Forbidden

- Direct DB writes from UI
- Cross-module business logic
- Silent security decisions
