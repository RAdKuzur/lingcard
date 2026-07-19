
export function getText(label) {
    const lang = localStorage.getItem('lang');
    if (lang) {
        return label[lang]
    }
    return label.ru
}

export const lang = {
    about: {
        me: {
            ru: "О нас",
            kz: "Біз туралы",
            en: "About us"
        },
        mission: {
            ru: "LingCard - это проект, который помогает людям учить языки с помощью простых интерактивных карточек.\n" +
                "Наша миссия - сделать изучение языков доступным, увлекательным и эффективным для каждого.",
            kz: "LingCard — бұл адамдарға қарапайым интерактивті карточкалар арқылы тіл үйренуге көмектесетін жоба.\n" +
                "Біздің миссиямыз — тіл үйренуді әркімге қолжетімді, қызықты әрі тиімді ету.",
            en: "LingCard is a project that helps people learn languages using simple interactive cards.\n" +
                "Our mission is to make language learning accessible, engaging, and effective for everyone."
        },
        contacts: {
            ru: "Контакты",
            kz: "Байланыс ақпараты",
            en: "Contacts"
        },
        languages: {
            ru: "Доступные слова",
            kz: "Қолжетімді тілдер",
            en: "Available languages"
        }
    },
    back: {
        button: {
            ru: "Назад",
            kz: "Артқа",
            en: "Back"
        }
    },
    navbar: {
        options: {
            training: {
                ru: "Тренировка",
                kz: "Жаттығу",
                en: "Training"
            },
            progress: {
                ru: "Прогресс",
                kz: "Прогресс",
                en: "Progress"
            },
            dictionary: {
                ru: "Словарь",
                kz: "Сөздік",
                en: "Dictionary"
            },
            about: {
                ru: "О нас",
                kz: "Біз туралы",
                en: "About us"
            }
        }
    },
    profileBar: {
        signIn: {
            ru: "Войти",
            kz: "Кіру",
            en: "Sign in"
        },
        guest: {
            ru: "Гость",
            kz: "Қонақ",
            en: "Guest"
        }
    },

    confirmRegister: {
        welcome: {
            ru: "Добро пожаловать в LingCard!",
            kz: "LingCard-қа қош келдіңіз!",
            en: "Welcome to LingCard!"
        },
        successfulCreated: {
            ru: "Ваш аккаунт успешно создан!",
            kz: "Аккаунтыңыз сәтті құрылды!",
            en: "Your account has been successfully created!"
        },
        startTraining: {
            ru: "Начать обучение",
            kz: "Оқуды бастау",
            en: "Start training"
        }
    },

    login: {
        mainLabel: {
            ru: "Вход в систему",
            kz: "Жүйеге кіру",
            en: "Login"
        },
        invalidCredentials: {
            ru: "Неправильный логин и/или пароль",
            kz: "Пайдаланушы аты немесе құпия сөз дұрыс емес",
            en: "Invalid username and/or password"
        },
        email: {
            ru: "Эл. почта",
            kz: "Электрондық пошта",
            en: "Email"
        },
        password: {
            ru: "Пароль",
            kz: "Құпиясөз",
            en: "Password"
        },
        signIn: {
            ru: "Войти",
            kz: "Кіру",
            en: "Sign in"
        },
        noAccount: {
            ru: "Нет аккаунта?",
            kz: "Аккаунтыңыз жоқ па?",
            en: "Don't have an account?"
        },
        signUp: {
            ru: "Зарегистрироваться",
            kz: "Тіркелу",
            en: "Sign up"
        }
    },
    register: {
        registerLabel: {
            ru: "Регистрация",
            kz: "Тіркелу",
            en: "Registration"
        },
        email: {
            ru: "Эл. почта",
            kz: "Электрондық пошта",
            en: "Email"
        },
        username: {
            ru: "Имя пользователя",
            kz: "Пайдаланушы аты",
            en: "Username"
        },
        password: {
            ru: "Пароль",
            kz: "Құпиясөз",
            en: "Password"
        },
        baseLang: {
            ru: "Базовый язык",
            kz: "Негізгі тіл",
            en: "Base language"
        },
        targetLang: {
            ru: "Язык изучения",
            kz: "Оқылатын тіл",
            en: "Target language"
        },
        createAccount: {
            ru: "Создать аккаунт",
            kz: "Аккаунт жасау",
            en: "Create account"
        },
        success: {
            ru: "Аккаунт создан успешно!",
            kz: "Аккаунт сәтті құрылды!",
            en: "Account created successfully!"
        },
        failed: {
            ru: "Ошибка создания аккаунта!",
            kz: "Аккаунт құру қатесі!",
            en: "Account creation failed!"
        }
    },
    dictionary: {
        dictionary: {
            ru: "Словарь",
            kz: "Сөздік",
            en: "Dictionary"
        },
        lang1: {
            ru: "Язык 1",
            kz: "1-тіл",
            en: "Language 1"
        },
        lang2: {
            ru: "Язык 2",
            kz: "2-тіл",
            en: "Language 2"
        },
        show: {
            ru: "Показать",
            kz: "Көрсету",
            en: "Show"
        },
        chooseLabel: {
            ru: "Выберите языки и нажмите \"Показать\"",
            kz: "Тілдерді таңдап, \"Көрсету\" батырмасын басыңыз",
            en: "Select languages and click \"Show\""
        },
        prev: {
            ru: "Пред.",
            kz: "Алд.",
            en: "Prev."
        },
        next: {
            ru: "След.",
            kz: "Келесі",
            en: "Next"
        },
        words: {
            ru: "Слова",
            kz: "Сөздер",
            en: "Words"
        },
        searchPlaceholder: {
            ru: "Поиск по слову (на базовом языке)",
            kz: "Сөз бойынша іздеу (негізгі тілде)",
            en: "Search by word (in base language)"
        }
    },
    home: {
        news: {
            ru: "Новости",
            kz: "Жаңалықтар",
            en: "News"
        }
    },
    selectedLanguage: {
        loading: {
            ru: "Загрузка...",
            kz: "Жүктелуде...",
            en: "Loading..."
        },
        errorLoading: {
            ru: "Ошибка загрузки",
            kz: "Жүктеу қатесі",
            en: "Loading error"
        },
        chooseLanguage: {
            ru: "Выберите язык...",
            kz: "Тілді таңдаңыз...",
            en: "Select language..."
        }
    },
    protectedRoute: {
        loading: {
            ru: "Загрузка...",
            kz: "Жүктелуде...",
            en: "Loading..."
        }
    },
    unprotectedRoute: {
        loading: {
            ru: "Загрузка...",
            kz: "Жүктелуде...",
            en: "Loading..."
        }
    },
    word: {
        clearProgress: {
            ru: "Сбросить прогресс",
            kz: "Прогресті қалпына келтіру",
            en: "Clear progress"
        }
    },
    profile: {
        error: {
            sameLanguages: {
                ru: "Базовый язык и язык изучения не могут быть одинаковыми",
                kz: "Негізгі тіл мен оқылатын тіл бірдей бола алмайды",
                en: "Base language and target language cannot be the same"
            },
            bothLanguages: {
                ru: "Пожалуйста, выберите оба языка",
                kz: "Екі тілді де таңдаңыз",
                en: "Please select both languages"
            },
            notChanged: {
                ru: "Языки не были изменены",
                kz: "Тілдер өзгертілмеді",
                en: "Languages were not changed"
            },
            failedUpdate: {
                ru: "Ошибка при обновлении настроек",
                kz: "Параметрлерді жаңарту кезінде қате орын алды",
                en: "Failed to update settings"
            }
        },
        success: {
            successChanged: {
                ru: "Настройки успешно обновлены!",
                kz: "Параметрлер сәтті жаңартылды!",
                en: "Settings updated successfully!"
            }
        },
        profileLabel: {
            ru: "Профиль",
            kz: "Профиль",
            en: "Profile"
        },
        baseLang: {
            ru: "Базовый язык",
            kz: "Негізгі тіл",
            en: "Base language"
        },
        targetLang: {
            ru: "Язык изучения",
            kz: "Оқылатын тіл",
            en: "Target language"
        },
        noChanged: {
            ru: "Нет изменений",
            kz: "Өзгеріс жоқ",
            en: "No changes"
        },
        buttonChange: {
            ru: "Изменить",
            kz: "Өзгерту",
            en: "Change"
        },
        stats: {
            ru: "Статистика",
            kz: "Статистика",
            en: "Statistics"
        },
        alreadyLearned: {
            ru: "Выучено слов",
            kz: "Үйренген сөздер",
            en: "Learned words"
        },
        learning: {
            ru: "Слов изучается",
            kz: "Оқылып жатқан сөздер",
            en: "Learning words"
        },
        noLearning: {
            ru: "Ещё не изучено",
            kz: "Әлі үйренілмеген",
            en: "Not learned yet"
        },
        signOut: {
            ru: "Выйти",
            kz: "Шығу",
            en: "Sign out"
        },
        clearProgress: {
            ru: "Сбросить прогресс",
            kz: "Прогресті қалпына келтіру",
            en: "Clear progress"
        }
    },
    progress: {
        newWords: {
            ru: "Новые слова",
            kz: "Жаңа сөздер",
            en: "New words"
        },
        learningWords: {
            ru: "Изучаемые слова",
            kz: "Оқылып жатқан сөздер",
            en: "Learning words"
        },
        learnedWords: {
            ru: "Изученные слова",
            kz: "Үйренген сөздер",
            en: "Learned words"
        },
        progressLabel: {
            ru: "Прогресс",
            kz: "Прогресс",
            en: "Progress"
        },
        chooseLabel: {
            ru: "Выберите языки и нажмите \"Показать\"",
            kz: "Тілдерді таңдап, \"Көрсету\" батырмасын басыңыз",
            en: "Select languages and click \"Show\""
        },
        noWords: {
            ru: "Нет слов",
            kz: "Сөздер жоқ",
            en: "No words"
        },
        words: {
            ru: "Слова",
            kz: "Сөздер",
            en: "Words"
        },
        prev: {
            ru: "Пред.",
            kz: "Алд.",
            en: "Prev."
        },
        next: {
            ru: "След.",
            kz: "Келесі",
            en: "Next"
        }
    },
    endTraining: {
        congratulations: {
            ru: "Поздравляем!",
            kz: "Құттықтаймыз!",
            en: "Congratulations!"
        },
        message:{
            ru: "Вы завершили обучение!",
            kz: "Сіз оқуды аяқтадыңыз!",
            en: "You have completed the training!"
        },
        continue: {
            ru: "Далее",
            kz: "Әрі қарай",
            en: "Next"
        }
    },
    waitingTraining: {
        alreadyWords: {
            ru: "На данный момент вы изучили все слова.",
            kz: "Қазіргі уақытта сіз барлық сөздерді оқып біттіңіз.",
            en: "You have learned all the words for now."
        },
        newWords: {
            ru: "Новые появятся через некоторое время.",
            kz: "Жаңа сөздер біраз уақыттан кейін пайда болады.",
            en: "New ones will appear after some time."
        },
        continue: {
            ru: "Далее",
            kz: "Әрі қарай",
            en: "Next"
        }
    },
    initWindows: {
        start: {
            ru: "Начать обучение",
            kz: "Оқуды бастау",
            en: "Start learning"
        }
    },
    training: {
        loading: {
            ru: "Загрузка...",
            kz: "Жүктелуде...",
            en: "Loading..."
        },
        unknown: {
            ru: "Не знаю",
            kz: "Білмеймін",
            en: "Don't know"
        },
        show: {
            ru: "Показать",
            kz: "Көрсету",
            en: "Show"
        },
        known: {
            ru: "Знаю",
            kz: "Білемін",
            en: "Know"
        },
        newWord: {
            ru: "Новое слово",
            kz: "Жаңа сөз",
            en: "New word"
        },
        amountRepeat: {
            ru: "Повторений: ",
            kz: "Қайталаулар: ",
            en: "Repetitions: "
        },
        hide: {
            ru: "Убрать",
            kz: "Жасыру",
            en: "Hide"
        }
    }
}
