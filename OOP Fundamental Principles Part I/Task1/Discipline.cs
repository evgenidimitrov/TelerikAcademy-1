﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace Task1
{
    class Discipline
    {
        public string Name { get; set; }
        public int NumberOfLectures { get; set; }
        public int NumberOfExercises { get; set; }
        
        public Discipline(string Name, int numberOfLectures, int numberOfExercises)
        {
            this.Name = Name;
            this.NumberOfExercises = numberOfExercises;
            this.NumberOfLectures = numberOfLectures;
        }
    }
}
