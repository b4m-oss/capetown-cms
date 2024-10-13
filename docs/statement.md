# Capetown CMS Statement

## Overview
A modern CMS equipped with the essential features needed for contemporary site management. Capetown CMS aims to be easily extendable for developers while keeping the learning curve minimal for implementers. It also seeks to be a destination for users migrating from WordPress by supporting many of its core features.

## Technology Stack

### Framework
- Laravel

### Testing & Linting
- **Unit & Integration Tests**: Pest
- **E2E Tests**: Laravel Dusk
- **Linter**: Pint

### Versioning
- Semantic Versioning

[See the milestones here](https://github.com/kohki-shikata/capetown-cms/milestones)

### Branch Strategy
- **main**: The production branch. Tags are applied during releases.
- **develop**: The development branch. Accepts pull requests from all feature branches.
- **{name-of-feature}**: Topic branches. The branch name should match the feature name. Use hyphens to connect up to 4 words (e.g., `custom-post-types`). Abbreviations (e.g., `develop` to `dev`) are acceptable. Keep names as short as possible.

### Naming Conventions
- Follow Laravel naming conventions for features related to Laravel.
- Use snake_case for all other PHP-related code (e.g., `snake_case_is_like_this`).

## WordPress Migration Support Strategy

### Support for Key Features
  1. Post, Page, Comment, Category, Tag, and User Authentication
  1. Custom Post Types & Custom Taxonomies
  1. Plugin System

### Basic WordPress Migration Strategy
  1. Only support imports from WordPress XML format.

### The following features will not be supported by default
  1. Theme functionality
  1. Trackbacks & Pingbacks
  1. Migration from Capetown back to WordPress
  1. Other rarely used features from WordPress

### Non-Standard WordPress Features to be included in Capetown
  1. SEO features (meta tags, OG tags, etc.)
  1. Form creation system
  1. Equivalent to Advanced Custom Fields

## Technical Strategy
- The database schema will be newly designed and will not follow the WordPress schema.
- Features will be developed according to Laravel’s best practices (Rails' way).
- While not a modular monolith, the system will be designed for extensibility by overriding Laravel.

## Testing Strategy
- We follow the testing pyramid approach.
- Unit and integration tests will require 80% coverage to pass.
- E2E tests will be minimal and focus on essential user cases, particularly those involving business logic.

## Non-Standard WordPress Features That Will Not Be Implemented
- E-commerce functionality

## Goals for Version 1.0
- Provide the standard WordPress features available prior to the introduction of Gutenberg.
