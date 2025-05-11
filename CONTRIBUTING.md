# Contributing to Hotel Management System

We appreciate your interest in contributing to the Hotel Management System. This document provides guidelines and instructions for contributing to this project.

## Development Process

### Setting Up Development Environment

1. Fork the repository
2. Clone your fork locally
3. Set up the development environment as described in the README.md
4. Create a new branch for your feature/fix

### Code Style Guidelines

#### PHP
- Follow PSR-12 coding standards
- Use type hints and return types where possible
- Document classes and methods using PHPDoc blocks
- Keep methods focused and single-responsibility
- Use meaningful variable and method names

#### JavaScript
- Use ES6+ features
- Follow airbnb style guide
- Document complex functions
- Use meaningful variable names
- Implement proper error handling

#### Blade Templates
- Use component-based architecture
- Keep logic out of views
- Use proper indentation
- Implement proper escaping

### Testing Requirements

- Write PHPUnit tests for new features
- Ensure all tests pass before submitting PR
- Include both unit and feature tests
- Maintain minimum 80% code coverage
- Test edge cases and error scenarios

### Git Workflow

1. Branch Naming:
   - feature/your-feature-name
   - bugfix/issue-description
   - hotfix/critical-fix

2. Commit Messages:
   - Use present tense ("Add feature" not "Added feature")
   - Be descriptive but concise
   - Reference issues and pull requests
   - Format: `[type]: Brief description`

3. Pull Request Process:
   - Create PR against the main branch
   - Fill out PR template completely
   - Request review from maintainers
   - Address review comments promptly

### Documentation

- Update README.md for new features
- Document configuration changes
- Include inline code comments
- Update API documentation if applicable

## Review Process

1. Code Review Guidelines:
   - Check code style compliance
   - Verify test coverage
   - Review documentation updates
   - Validate feature functionality

2. Acceptance Criteria:
   - All tests passing
   - Code review approved
   - Documentation updated
   - No merge conflicts
   - Meets project standards

## Reporting Issues

### Bug Reports
Include:
- Clear description
- Steps to reproduce
- Expected vs actual behavior
- System information
- Screenshots if applicable

### Feature Requests
Include:
- Clear description of the feature
- Use case and benefits
- Possible implementation approach
- Any relevant examples

## Community Guidelines

- Be respectful and inclusive
- Help others when possible
- Follow the code of conduct
- Participate in discussions constructively

Thank you for contributing to make the Hotel Management System better!