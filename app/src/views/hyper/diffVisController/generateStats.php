<script>
    async function generateStats(url) {

        $('#button_generate_stats').hide();
        $('#button_loading_stats').show();

        // Ciclista 1
        await axios.put(url, {
                'ciclista_1': {
                    'total_atividades': 750,
                    'total_subsets': 4,
                    'subset_1': {
                        'total_atividades': 136,
                        'Quantidade de nós': 15,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Heartrate, Cadence, Latitude, Longitude"
                    },
                    'subset_2': {
                        'total_atividades': 259,
                        'Quantidade de nós': 14,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Heartrate, Latitude, Longitude"
                    },
                    'subset_3': {
                        'total_atividades': 267,
                        'Quantidade de nós': 13,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Latitude e Longitude"
                    },
                    'subset_4': {
                        'total_atividades': 88,
                        'Quantidade de nós': 13,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Latitude e Longitude"
                    }
                },
                'ciclista_2': {
                    'total_atividades': 388,
                    'total_subsets': 3,
                    'subset_1': {
                        'total_atividades': 306,
                        'Quantidade de nós': 14,
                        'Dados disponíveis': "DateTime, Elevation, Heartrate, Temperature, Latitude, Longitude"
                    },
                    'subset_2': {
                        'total_atividades': 75,
                        'Quantidade de nós': 13,
                        'Dados disponíveis': "DateTime, Elevation, Heartrate, Latitude, Longitude"
                    },
                    'subset_3': {
                        'total_atividades': 7,
                        'Quantidade de nós': 10,
                        'Dados disponíveis': "Datetime, Elevation, Latitude, Longitude"
                    }
                },
                'ciclista_3': {
                    'total_atividades': 661,
                    'total_subsets': 4,
                    'subset_1': {
                        'total_atividades': 198,
                        'Quantidade de nós': 14,
                        'Dados disponíveis': "DateTime, Elevation, Heartrate, Temperature, Latitude, Longitude"
                    },
                    'subset_2': {
                        'total_atividades': 376,
                        'Quantidade de nós': 13,
                        'Dados disponíveis': "DateTime, Elevation, Heartrate, Latitude, Longitude"
                    },
                    'subset_3': {
                        'total_atividades': 85,
                        'Quantidade de nós': 10,
                        'Dados disponíveis': "Datetime, Elevation, Latitude, Longitude"
                    },
                    'subset_4': {
                        'total_atividades': 2,
                        'Quantidade de nós': 9,
                        'Dados disponíveis': "Datetime, Latitude, Longitude"
                    }
                },
                'ciclista_4': {
                    'total_atividades': 810,
                    'total_subsets': 4,
                    'subset_1': {
                        'total_atividades': 35,
                        'Quantidade de nós': 15,
                        'Dados disponíveis': "DateTime, Elevation, Heartrate, Temperature, Cadence, Latitude, Longitude"
                    },
                    'subset_2': {
                        'total_atividades': 478,
                        'Quantidade de nós': 14,
                        'Dados disponíveis': "DateTime, Elevation, Heartrate, Temperature, Latitude, Longitude"
                    },
                    'subset_3': {
                        'total_atividades': 263,
                        'Quantidade de nós': 13,
                        'Dados disponíveis': "Datetime, Elevation, Temperature, Latitude, Longitude"
                    },
                    'subset_4': {
                        'total_atividades': 34,
                        'Quantidade de nós': 10,
                        'Dados disponíveis': "Datetime, Elevation, Latitude, Longitude"
                    }
                },
                'ciclista_5': {
                    'total_atividades': 636,
                    'total_subsets': 3,
                    'subset_1': {
                        'total_atividades': 1,
                        'Quantidade de nós': 14,
                        'Dados disponíveis': "DateTime, Elevation, Heartrate, Cadence, Latitude, Longitude"
                    },
                    'subset_2': {
                        'total_atividades': 457,
                        'Quantidade de nós': 13,
                        'Dados disponíveis': "DateTime, Elevation, Heartrate, Latitude, Longitude"
                    },
                    'subset_3': {
                        'total_atividades': 178,
                        'Quantidade de nós': 10,
                        'Dados disponíveis': "Datetime, Elevation, Latitude, Longitude"
                    }
                },
                'ciclista_6': {
                    'total_atividades': 63,
                    'total_subsets': 2,
                    'subset_1': {
                        'total_atividades': 51,
                        'Quantidade de nós': 13,
                        'Dados disponíveis': "DateTime, Elevation, Heartrate, Latitude, Longitude"
                    },
                    'subset_2': {
                        'total_atividades': 12,
                        'Quantidade de nós': 10,
                        'Dados disponíveis': "DateTime, Elevation, Latitude, Longitude"
                    }
                },
                'ciclista_7': {
                    'total_atividades': 328,
                    'total_subsets': 3,
                    'subset_1': {
                        'total_atividades': 27,
                        'Quantidade de nós': 15,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Heartrate, Cadence, Latitude, Longitude"
                    },
                    'subset_2': {
                        'total_atividades': 294,
                        'Quantidade de nós': 14,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Heartrate, Latitude, Longitude"
                    },
                    'subset_3': {
                        'total_atividades': 7,
                        'Quantidade de nós': 13,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Latitude, Longitude"
                    }
                },
                'ciclista_8': {
                    'total_atividades': 141,
                    'total_subsets': 12,
                    'subset_1': {
                        'total_atividades': 2,
                        'Quantidade de nós': 46,
                        'Dados disponíveis': "DateTime, Time, Distance, Speed, Heartrate, Cadence, Calories, Latitude, Longitude,Altitude, Watts"
                    },
                    'subset_2': {
                        'total_atividades': 19,
                        'Quantidade de nós': 43,
                        'Dados disponíveis': "DateTime, Time, Distance, Speed, Heartrate, Cadence, Calories, Latitude, Longitude, Altitude"
                    },
                    'subset_3': {
                        'total_atividades': 2,
                        'Quantidade de nós': 42,
                        'Dados disponíveis': "DateTime, Time, Distance, Speed, Cadence, Calories, Latitude, Longitude, Altitude"
                    },
                    'subset_4': {
                        'total_atividades': 35,
                        'Quantidade de nós': 41,
                        'Dados disponíveis': "DateTime, Time, Distance, Speed, Cadence, Calories, Latitude, Longitude, Altitude"
                    },
                    'subset_5': {
                        'total_atividades': 1,
                        'Quantidade de nós': 40,
                        'Dados disponíveis': "DateTime, Time, Distance, Speed, Heartrate, Calories, Cadence, Altitude"
                    },
                    'subset_6': {
                        'total_atividades': 4,
                        'Quantidade de nós': 39,
                        'Dados disponíveis': "DateTime, Time, Distance, Speed, Calories, Cadence, Latitude, Longitude, Altitude, Speed"
                    },
                    'subset_7': {
                        'total_atividades': 62,
                        'Quantidade de nós': 37,
                        'Dados disponíveis': "DateTime, Time, Distance, Speed, Calories, Latitude, Longitude, Altitude, Speed"
                    },
                    'subset_8': {
                        'total_atividades': 1,
                        'Quantidade de nós': 36,
                        'Dados disponíveis': "DateTime, Time, Distance, Speed, Calories, Cadence, Altitude, Speed"
                    },
                    'subset_9': {
                        'total_atividades': 7,
                        'Quantidade de nós': 35,
                        'Dados disponíveis': "DateTime, Time, Distance, Heartrate, Altitude, Speed"
                    },
                    'subset_10': {
                        'total_atividades': 1,
                        'Quantidade de nós': 33,
                        'Dados disponíveis': "DateTime, Time, Distance, Cadence, Altitude, Speed"
                    },
                    'subset_11': {
                        'total_atividades': 6,
                        'Quantidade de nós': 31,
                        'Dados disponíveis': "DateTime, Time, Distance, Calories, Altitude, Speed"
                    },
                    'subset_12': {
                        'total_atividades': 1,
                        'Quantidade de nós': 28,
                        'Dados disponíveis': "DateTime, Time, Distance, Calories, Speed"
                    }
                },
                'ciclista_9': {
                    'total_atividades': 602,
                    'total_subsets': 12,
                    'subset_1': {
                        'total_atividades': 161,
                        'Quantidade de nós': 46,
                        'Dados disponíveis': "DateTime, Time, Distance, Speed, Heartrate, Cadence, Calories, Latitude, Longitude,Altitude, Watts"
                    },
                    'subset_2': {
                        'total_atividades': 5,
                        'Quantidade de nós': 44,
                        'Dados disponíveis': "DateTime, Time, Distance, Speed, Heartrate, Cadence, Calories, Latitude, Longitude, Altitude"
                    },
                    'subset_3': {
                        'total_atividades': 27,
                        'Quantidade de nós': 43,
                        'Dados disponíveis': "DateTime, Time, Distance, Speed, Heartrate, Cadence, Calories, Altitude"
                    },
                    'subset_4': {
                        'total_atividades': 3,
                        'Quantidade de nós': 42,
                        'Dados disponíveis': "DateTime, Time, Distance, Speed, Heartrate, Calories, Latitude, Longitude, Altitude"
                    },
                    'subset_5': {
                        'total_atividades': 233,
                        'Quantidade de nós': 41,
                        'Dados disponíveis': "DateTime, Time, Distance, Speed, Heartrate, Calories, Cadence, Latitude, Longitude, Altitude"
                    },
                    'subset_6': {
                        'total_atividades': 21,
                        'Quantidade de nós': 40,
                        'Dados disponíveis': "DateTime, Time, Distance, Speed, Heartrate, Calories, Cadence, Altitude, Speed"
                    },
                    'subset_7': {
                        'total_atividades': 62,
                        'Quantidade de nós': 39,
                        'Dados disponíveis': "DateTime, Time, Distance, Speed, Calories, Latitude, Longitude, Altitude, Speed"
                    },
                    'subset_8': {
                        'total_atividades': 120,
                        'Quantidade de nós': 38,
                        'Dados disponíveis': "DateTime, Time, Distance, Speed, Heartrate, Calories, Altitude, Speed"
                    },
                    'subset_9': {
                        'total_atividades': 1,
                        'Quantidade de nós': 37,
                        'Dados disponíveis': "DateTime, Time, Distance, Calories, Heartrate, Altitude, Speed"
                    },
                    'subset_10': {
                        'total_atividades': 1,
                        'Quantidade de nós': 36,
                        'Dados disponíveis': "DateTime, Time, Distance, Calories, Heartrate,Cadence, Altitude, Speed"
                    },
                    'subset_11': {
                        'total_atividades': 25,
                        'Quantidade de nós': 35,
                        'Dados disponíveis': "DateTime, Time, Distance, Calories, Heartrate, Speed"
                    },
                    'subset_12': {
                        'total_atividades': 1,
                        'Quantidade de nós': 34,
                        'Dados disponíveis': "DateTime, Time, Distance, Calories, Speed"
                    }
                },
                'ciclista_10': {
                    'total_atividades': 650,
                    'total_subsets': 3,
                    'subset_1': {
                        'total_atividades': 286,
                        'Quantidade de nós': 17,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Heartrate, Cadence, Latitude, Longitude"
                    },
                    'subset_2': {
                        'total_atividades': 363,
                        'Quantidade de nós': 16,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Heartrate, Latitude, Longitude"
                    },
                    'subset_3': {
                        'total_atividades': 1,
                        'Quantidade de nós': 15,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Latitude, Longitude"
                    }
                },
                'ciclista_11': {
                    'total_atividades': 844,
                    'total_subsets': 5,
                    'subset_1': {
                        'total_atividades': 20,
                        'Quantidade de nós': 15,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Heartrate, Cadence, Latitude, Longitude"
                    },
                    'subset_2': {
                        'total_atividades': 273,
                        'Quantidade de nós': 14,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Heartrate, Latitude, Longitude"
                    },
                    'subset_3': {
                        'total_atividades': 429,
                        'Quantidade de nós': 13,
                        'Dados disponíveis': "DateTime, Elevation, Heartrate, Latitude, Longitude"
                    },
                    'subset_4': {
                        'total_atividades': 120,
                        'Quantidade de nós': 10,
                        'Dados disponíveis': "DateTime, Elevation, Latitude, Longitude"
                    },
                    'subset_5': {
                        'total_atividades': 2,
                        'Quantidade de nós': 9,
                        'Dados disponíveis': "DateTime, Latitude, Longitude"
                    }
                },
                'ciclista_12': {
                    'total_atividades': 512,
                    'total_subsets': 5,
                    'subset_1': {
                        'total_atividades': 421,
                        'Quantidade de nós': 14,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Heartrate, Latitude, Longitude"
                    },
                    'subset_2': {
                        'total_atividades': 82,
                        'Quantidade de nós': 13,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Latitude, Longitude"
                    },
                    'subset_3': {
                        'total_atividades': 9,
                        'Quantidade de nós': 10,
                        'Dados disponíveis': "DateTime, Elevation, Latitude, Longitude"
                    }
                },
                'ciclista_13': {
                    'total_atividades': 432,
                    'total_subsets': 2,
                    'subset_1': {
                        'total_atividades': 355,
                        'Quantidade de nós': 13,
                        'Dados disponíveis': "DateTime, Elevation, Heartrate, Latitude, Longitude"
                    },
                    'subset_2': {
                        'total_atividades': 77,
                        'Quantidade de nós': 10,
                        'Dados disponíveis': "DateTime, Elevation, Latitude, Longitude"
                    }
                },
                'ciclista_14': {
                    'total_atividades': 491,
                    'total_subsets': 3,
                    'subset_1': {
                        'total_atividades': 56,
                        'Quantidade de nós': 15,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Cadence, Heartrate, Latitude, Longitude"
                    },
                    'subset_2': {
                        'total_atividades': 424,
                        'Quantidade de nós': 14,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Heartrate, Latitude, Longitude"
                    },
                    'subset_3': {
                        'total_atividades': 11,
                        'Quantidade de nós': 13,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Latitude, Longitude"
                    }
                },
                'ciclista_15': {
                    'total_atividades': 448,
                    'total_subsets': 4,
                    'subset_1': {
                        'total_atividades': 150,
                        'Quantidade de nós': 15,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Cadence, Heartrate, Latitude, Longitude"
                    },
                    'subset_2': {
                        'total_atividades': 146,
                        'Quantidade de nós': 14,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Heartrate, Latitude, Longitude"
                    },
                    'subset_3': {
                        'total_atividades': 2,
                        'Quantidade de nós': 13,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Latitude, Longitude"
                    },
                    'subset_4': {
                        'total_atividades': 150,
                        'Quantidade de nós': 10,
                        'Dados disponíveis': "DateTime, Elevation, Latitude, Longitude"
                    }
                },
                'ciclista_16': {
                    'total_atividades': 1496,
                    'total_subsets': 3,
                    'subset_1': {
                        'total_atividades': 1,
                        'Quantidade de nós': 14,
                        'Dados disponíveis': "DateTime, Elevation, Cadence, Heartrate, Latitude, Longitude"
                    },
                    'subset_2': {
                        'total_atividades': 1155,
                        'Quantidade de nós': 13,
                        'Dados disponíveis': "DateTime, Elevation, Heartrate, Latitude, Longitude"
                    },
                    'subset_3': {
                        'total_atividades': 340,
                        'Quantidade de nós': 10,
                        'Dados disponíveis': "DateTime, Elevation, Latitude, Longitude"
                    }
                },
                'ciclista_17': {
                    'total_atividades': 447,
                    'total_subsets': 3,
                    'subset_1': {
                        'total_atividades': 168,
                        'Quantidade de nós': 18,
                        'Dados disponíveis': "DateTime, Elevation, Cadence, Temperature, Heartrate, Latitude, Longitude"
                    },
                    'subset_2': {
                        'total_atividades': 241,
                        'Quantidade de nós': 17,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Heartrate, Latitude, Longitude"
                    },
                    'subset_3': {
                        'total_atividades': 38,
                        'Quantidade de nós': 16,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Latitude, Longitude"
                    }
                },
                'ciclista_18': {
                    'total_atividades': 648,
                    'total_subsets': 3,
                    'subset_1': {
                        'total_atividades': 496,
                        'Quantidade de nós': 17,
                        'Dados disponíveis': "DateTime, Elevation, Cadence, Temperature, Heartrate, Latitude, Longitude"
                    },
                    'subset_2': {
                        'total_atividades': 146,
                        'Quantidade de nós': 16,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Heartrate, Latitude, Longitude"
                    },
                    'subset_3': {
                        'total_atividades': 7,
                        'Quantidade de nós': 15,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Latitude, Longitude"
                    }
                },
                'ciclista_19': {
                    'total_atividades': 144,
                    'total_subsets': 4,
                    'subset_1': {
                        'total_atividades': 8,
                        'Quantidade de nós': 18,
                        'Dados disponíveis': "DateTime, Elevation, Cadence, Temperature, Heartrate, Latitude, Longitude"
                    },
                    'subset_2': {
                        'total_atividades': 29,
                        'Quantidade de nós': 17,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Heartrate, Latitude, Longitude"
                    },
                    'subset_3': {
                        'total_atividades': 102,
                        'Quantidade de nós': 16,
                        'Dados disponíveis': "DateTime, Elevation, Heartrate, Latitude, Longitude"
                    },
                    'subset_4': {
                        'total_atividades': 5,
                        'Quantidade de nós': 15,
                        'Dados disponíveis': "DateTime, Elevation, Latitude, Longitude"
                    }
                },
                'ciclista_20': {
                    'total_atividades': 205,
                    'total_subsets': 3,
                    'subset_1': {
                        'total_atividades': 37,
                        'Quantidade de nós': 14,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Heartrate, Latitude, Longitude"
                    },
                    'subset_2': {
                        'total_atividades': 114,
                        'Quantidade de nós': 13,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Latitude, Longitude"
                    },
                    'subset_3': {
                        'total_atividades': 54,
                        'Quantidade de nós': 10,
                        'Dados disponíveis': "DateTime, Elevation, Latitude, Longitude"
                    }
                },
                'ciclista_21': {
                    'total_atividades': 227,
                    'total_subsets': 3,
                    'subset_1': {
                        'total_atividades': 140,
                        'Quantidade de nós': 17,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Heartrate, Cadence, Latitude, Longitude"
                    },
                    'subset_2': {
                        'total_atividades': 79,
                        'Quantidade de nós': 16,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Heartrate, Latitude, Longitude"
                    },
                    'subset_3': {
                        'total_atividades': 8,
                        'Quantidade de nós': 15,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Latitude, Longitude"
                    }
                },
                'ciclista_22': {
                    'total_atividades': 490,
                    'total_subsets': 4,
                    'subset_1': {
                        'total_atividades': 11,
                        'Quantidade de nós': 16,
                        'Dados disponíveis': "DateTime, Elevation, Heartrate, Cadence, Latitude, Longitude"
                    },
                    'subset_2': {
                        'total_atividades': 417,
                        'Quantidade de nós': 15,
                        'Dados disponíveis': "DateTime, Elevation, Heartrate, Latitude, Longitude"
                    },
                    'subset_3': {
                        'total_atividades': 61,
                        'Quantidade de nós': 12,
                        'Dados disponíveis': "DateTime, Elevation, Latitude, Longitude"
                    },
                    'subset_4': {
                        'total_atividades': 1,
                        'Quantidade de nós': 11,
                        'Dados disponíveis': "DateTime, Latitude, Longitude"
                    }
                },
                'ciclista_23': {
                    'total_atividades': 466,
                    'total_subsets': 3,
                    'subset_1': {
                        'total_atividades': 433,
                        'Quantidade de nós': 17,
                        'Dados disponíveis': "DateTime, Elevation, Heartrate, Temperature, Latitude, Longitude"
                    },
                    'subset_2': {
                        'total_atividades': 30,
                        'Quantidade de nós': 16,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Latitude, Longitude"
                    },
                    'subset_3': {
                        'total_atividades': 3,
                        'Quantidade de nós': 15,
                        'Dados disponíveis': "DateTime, Elevation, Latitude, Longitude"
                    }
                },
                'ciclista_24': {
                    'total_atividades': 755,
                    'total_subsets': 4,
                    'subset_1': {
                        'total_atividades': 270,
                        'Quantidade de nós': 15,
                        'Dados disponíveis': "DateTime, Elevation, Heartrate, Temperature, Cadence, Latitude, Longitude"
                    },
                    'subset_2': {
                        'total_atividades': 270,
                        'Quantidade de nós': 14,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Heartrate, Latitude, Longitude"
                    },
                    'subset_3': {
                        'total_atividades': 3,
                        'Quantidade de nós': 13,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Latitude, Longitude"
                    },
                    'subset_4': {
                        'total_atividades': 212,
                        'Quantidade de nós': 10,
                        'Dados disponíveis': "DateTime, Elevation, Latitude, Longitude"
                    }
                },
                'ciclista_25': {
                    'total_atividades': 954,
                    'total_subsets': 3,
                    'subset_1': {
                        'total_atividades': 507,
                        'Quantidade de nós': 18,
                        'Dados disponíveis': "DateTime, Elevation, Heartrate, Temperature, Cadence, Latitude, Longitude"
                    },
                    'subset_2': {
                        'total_atividades': 442,
                        'Quantidade de nós': 17,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Heartrate, Latitude, Longitude"
                    },
                    'subset_3': {
                        'total_atividades': 5,
                        'Quantidade de nós': 16,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Latitude, Longitude"
                    }
                },
                'ciclista_26': {
                    'total_atividades': 1108,
                    'total_subsets': 3,
                    'subset_1': {
                        'total_atividades': 54,
                        'Quantidade de nós': 15,
                        'Dados disponíveis': "DateTime, Elevation, Heartrate, Temperature, Cadence, Latitude, Longitude"
                    },
                    'subset_2': {
                        'total_atividades': 339,
                        'Quantidade de nós': 14,
                        'Dados disponíveis': "DateTime, Elevation, Temperature, Heartrate, Latitude, Longitude"
                    },
                    'subset_3': {
                        'total_atividades': 508,
                        'Quantidade de nós': 13,
                        'Dados disponíveis': "DateTime, Elevation, Heartrate, Latitude, Longitude"
                    },
                    'subset_4': {
                        'total_atividades': 205,
                        'Quantidade de nós': 10,
                        'Dados disponíveis': "DateTime, Elevation, Latitude, Longitude"
                    },
                    'subset_5': {
                        'total_atividades': 2,
                        'Quantidade de nós': 9,
                        'Dados disponíveis': "DateTime, Latitude, Longitude"
                    }
                },
                'ciclista_27': {
                    'total_atividades': 2115,
                    'total_subsets': 10,
                    'subset_1': {
                        'total_atividades': 487,
                        'Quantidade de nós': 47,
                        'Dados disponíveis': "DateTime, Time, Distance, Speed, Heartrate, Cadence, Calories, Latitude, Longitude,Altitude, Watts"
                    },
                    'subset_2': {
                        'total_atividades': 308,
                        'Quantidade de nós': 44,
                        'Dados disponíveis': "DateTime, Time, Distance, Speed, Heartrate, Cadence, Calories, Latitude, Longitude, Altitude"
                    },
                    'subset_3': {
                        'total_atividades': 10,
                        'Quantidade de nós': 43,
                        'Dados disponíveis': "DateTime, Time, Distance, Speed, Heartrate, Cadence, Calories, Latitude, Longitude, Altitude, Watts"
                    },
                    'subset_4': {
                        'total_atividades': 1093,
                        'Quantidade de nós': 41,
                        'Dados disponíveis': "DateTime, Time, Distance, Speed, Heartrate, Calories, Latitude, Longitude, Altitude, Speed"
                    },
                    'subset_5': {
                        'total_atividades': 19,
                        'Quantidade de nós': 40,
                        'Dados disponíveis': "DateTime, Time, Distance, Speed, Calories, Cadence, Altitude, Speed"
                    },
                    'subset_6': {
                        'total_atividades': 2,
                        'Quantidade de nós': 38,
                        'Dados disponíveis': "DateTime, Time, Distance, Speed, Heartrate, Calories, Altitude, Speed"
                    },
                    'subset_7': {
                        'total_atividades': 62,
                        'Quantidade de nós': 39,
                        'Dados disponíveis': "DateTime, Time, Distance, Speed, Calories, Latitude, Longitude, Altitude, Speed"
                    },
                    'subset_8': {
                        'total_atividades': 120,
                        'Quantidade de nós': 38,
                        'Dados disponíveis': "DateTime, Time, Distance, Speed, Heartrate, Calories, Altitude, Speed"
                    },
                    'subset_9': {
                        'total_atividades': 50,
                        'Quantidade de nós': 37,
                        'Dados disponíveis': "DateTime, Time, Distance, Calories, Cadence, Altitude, Watts"
                    },
                    'subset_10': {
                        'total_atividades': 14,
                        'Quantidade de nós': 35,
                        'Dados disponíveis': "DateTime, Time, Distance, Calories, Heartrate"
                    },
                    'subset_11': {
                        'total_atividades': 52,
                        'Quantidade de nós': 34,
                        'Dados disponíveis': "DateTime, Time, Distance, Calories, Heartrate"
                    }
                },

            })
            .then(function(res) {

                console.log(res);
            })
            .catch(function(error) {
                console.log("Erro");
                console.log(error);
                $('#button_generate_stats').hide();
                $('#button_loading_stats').hide();
                $('#button_success_stats').hide();
                $('#button_danger_stats').show();
                $('#error_extract').text(error);
                return; // Paralizando continuidade do código
            });

        $('#button_loading_stats').hide();
        $('#button_success_stats').show();


    }
</script>