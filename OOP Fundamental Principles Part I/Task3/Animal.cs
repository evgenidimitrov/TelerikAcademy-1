﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace Task3
{
    public abstract class Animal
    {
        public int Age { get; set; }
        public string Name { get; set; }
        public char Sex { get; set; }
        
        public Animal(int age, string name, char sex)
        {
            this.Age = age;
            this.Name = name;
            this.Sex = sex;
        }
        
        public abstract void ProduceSound();
        
        public void IdentifyAnimal()
        {
            Console.WriteLine("I am " + GetType().Name);
            ProduceSound();
        }

        public static double Average(Animal[] array)
        {
            double sum = 0;
            for (int i = 0; i < array.Length; i++)
            {
                sum = sum + array[i].Age;
            }
            return sum / array.Length;
        }
    }
}
