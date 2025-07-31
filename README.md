# Xing Xing Coin - Meme Tool 🚀

## 🛠 Requirements
- [DDEV](https://ddev.readthedocs.io/en/stable/) (version 1.24+ recommended)

## 🚀 Start/Stop environment
Start environment:
```
ddev start
```
End DDEV:
```
ddev poweroff
```
Stop environment:
```
ddev stop
```

## 🧪 Unit Tests
1. activate XDebug:
```
ddev xdebug on
```
2. Start phpunit tests (with coverage):
```
ddev unit
```
3. Start jest unit tests (with coverage):
```
ddev jest
```

## 🧪 Acceptance Tests
```
ddev acceptance
```

## 🧪 Psalm
```
ddev psalm
```

## 🧪 Infection:
1. activate XDebug:
```
ddev xdebug on
```
2. Start infection:
```
ddev infection
```
